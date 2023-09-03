<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerifyEmail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AuthController extends Controller
{

    public function getUser()
    {
        $auth = Auth::user();

        if (!auth()) {
            return response()->json([
                "data" => null,
                "status" => false
            ], 401);
        }
        return response()->json([
            "data" => $auth,
            "status" => true
        ]);
    }

    public function register(Request $request)
    {
        $userController = new UserController();
        $data = $userController->store($request);
        $data = $data->original;
        if ($data['status'] == true) {
            $user = $data['data'];
            SendVerifyEmail::dispatch($user->id);
        }
        activity()->performedOn($user)
            ->causedBy($user)
            ->event('CREATE')
            ->log('register new account');
        return $data;
    }

    public function login(Request $request)
    {
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($credentials)) {
            return $this->responseMessage([], false, 'Invalid credentials');
        }
        $user = User::find(Auth::user()->id);
        if (!$user->hasVerifiedEmail()) {
            return $this->responseMessage([], false, 'Email is not verified');
        }
        $token = $user->createToken('auth');

        activity()->performedOn($user)
            ->causedBy($user)
            ->event('READ')
            ->log('login');

        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
            'user' => $user,
            'status' => true,
        ]);
    }

    function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        activity()->performedOn($user)
            ->causedBy($user)
            ->event('UPDATE')
            ->log('logout');
        return response()->json([
            'message' => 'Logged out',
            'status' => true,
        ], 200);
    }

    public function verifyEmail($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect('/login')->with('error', 'User tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('info', 'Email sudah terverifikasi sebelumnya.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            activity()->performedOn($user)
                ->causedBy($user)
                ->event('UPDATE')
                ->log('verify email');
            return redirect('/login')->with('success', 'Email berhasil diverifikasi.');
        }

        return redirect('/login')->with('error', 'Gagal verifikasi email.');
    }
}
