<?php

namespace App\Jobs;

use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBatchVerifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    {
    }

    public function handle(): void
    {
        $today = Carbon::today();
        $users = User::where('email_verified_at', null)->whereDate('created_at', $today)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new VerifyEmail($user));
        }
    }
}
