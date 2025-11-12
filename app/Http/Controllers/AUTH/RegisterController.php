<?php

namespace App\Http\Controllers\AUTH;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm(){
        return view('auth.register');
    }

    public function register(RegisterRequest $request){

        $data = $request->validated();

        $user = User::create([
            'pseudo' => $data['pseudo'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        event(new Registered($user));

        return response()->json([
            'success' => true,
            'message' => __('register.register_success'),
        ]);
    }
}
