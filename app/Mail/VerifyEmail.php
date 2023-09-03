<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $verifyUrl;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('mail.verify-email')
            ->subject('Verifikasi Email') 
            ->with(['user' => $this->user]); // Data yang akan dipass ke template
    }
}
