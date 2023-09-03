<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerifyEmail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $userController = new UserController();
        $data = $userController->store($request);
        $data = $data->original;
        if($data['status'] == true){
            $user = $data['data'];
            SendVerifyEmail::dispatch($user->id, false);
        }
        return $data;
    }

    public function login(Request $request)
    {
        //validate the incoming request
        $credentials = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //check if email and password matches
        if (!auth()->attempt($credentials)) {
            return $this->responseMessage([], false, 'Invalid credentials');
        }
        $user = User::find(Auth::user()->id);
        $token = $user->createToken('auth');
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
        return response()->json([
            'message' => 'Logged out',
            'status' => true,
        ], 200);
    }

    public function verifyEmail($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('info', 'Email sudah terverifikasi sebelumnya.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            return redirect()->route('login')->with('success', 'Email berhasil diverifikasi.');
        }

        return redirect()->route('login')->with('error', 'Gagal verifikasi email.');
    }
}
