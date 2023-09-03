<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\InsertMassUser;
use App\Jobs\SendBatchVerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = User::all();
        activity()
            ->causedBy(Auth::user())
            ->event('READ')
            ->log('get all data user');
        return $this->responseMessage($userData, true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userData = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => bcrypt($request->password),
        ]);
        activity()
            ->causedBy(Auth::user())
            ->event('CREATE')
            ->log('create new data user');
        return $this->responseMessage($userData, true);
    }

    public function batchInsert(Request $request)
    {
        $data = $request->json('data');
        InsertMassUser::dispatch($data);
        SendBatchVerifyEmail::dispatch();
        activity()
            ->causedBy(Auth::user())
            ->event('CREATE')
            ->log('create new data user');
        return $this->responseMessage([], true, 'Data Sedang Dimasukan');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        activity()
            ->causedBy(Auth::user())
            ->event('READ')
            ->performedOn($user)
            ->log('get data user');
        return $this->responseMessage($user, true);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $userData = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => bcrypt($request->password),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('UPDATE')
            ->log('update data user');
        return $this->responseMessage($userData, true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $userData = $user->delete();

        activity()
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->event('DELETE')
            ->log('delete data user');
        return $this->responseMessage($userData, true);
    }
}
