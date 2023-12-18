<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $user;
    
    public function __construct($mailData, $user)
    {
        $this->mailData = $mailData;
        $this->user = $user;
    }

    public function build(){
        return $this->subject('New comment has been added')->view('emails.createcommentmail');
    }
}
