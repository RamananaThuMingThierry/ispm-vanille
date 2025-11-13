<?php

namespace App\Http\Controllers\FRONT;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Envoi email
        Mail::to('contact@cci.mg')
            ->send(new ContactMessage($request->all()));

        return back()->with('success', 'Votre message a été envoyé avec succès.');
    }
}
