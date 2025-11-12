<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class NewUserNotification extends Mailable
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Nouveau compte utilisateur créé')
                    ->view('emails.new_user_notification')
                    ->with([
                        'user' => $this->user,
                    ]);
    }
}

