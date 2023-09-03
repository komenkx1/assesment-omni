<?php

namespace App\Jobs;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newUserId;
    protected $isMassInsert;

    public function __construct($newUserId, $isMassInsert = false)
    {
        $this->newUserId = $newUserId;
        $this->isMassInsert = $isMassInsert;
    }

    public function handle()
    {
        if ($this->isMassInsert == true) {
            $users = User::whereIn('id',  $this->newUserId)->get();
            $users->chunk(2, function ($items) {
                $count = count($items);
                for ($i = 0; $i < $count; $i++) {
                    $user = $items[$i];
                    if ($user) {
                        Mail::to($user->email)->send(new VerifyEmail($user));
                        if ($i < $count - 1) {
                            sleep(15); // Hanya tidur jika bukan item terakhir
                        }
                    }
                }
            });
        } else {
            $user = User::find($this->newUserId);
            if ($user) {
                Mail::to($user->email)->send(new VerifyEmail($user));
            }
        }
    }
}
