<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\InsertMassUser;
use App\Jobs\SendBatchVerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userData = User::all();
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
        return $this->responseMessage($userData, true);
    }

    public function batchInsert(Request $request)
    {
        $data = $request->json('data');
        InsertMassUser::dispatch($data);
        SendBatchVerifyEmail::dispatch();
        return $this->responseMessage([], true, 'Data Sedang Dimasukan');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
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
        return $this->responseMessage($userData, true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $userData = $user->delete();
        return $this->responseMessage($userData, true);
    }
}
