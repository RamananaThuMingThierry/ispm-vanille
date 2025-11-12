<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Autoriser cette requête pour tous les utilisateurs
    }

    /**
     * Règles de validation de la requête.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pseudo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contact' =>  ['required','size:10','regex:/^0(32|33|34|37|38)\d{7}$/'],
            'address' => ['required','string'],
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * Messages personnalisés pour les erreurs de validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pseudo.required' => 'Le pseudo est obligatoire.',
            'pseudo.max' => 'Le pseudo ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'contact.required' => 'Le contact est obligatoire.',
            'contact.size' => 'Le contact doit contenir exactement 10 chiffres.',
            'contact.regex' => 'Le contact doit commencer par 032, 033, 034, 037 ou 038 et être suivi de 7 chiffres.',
            'adresse.required' => 'L\'adresse est obligatoire.',
            'adresse.string' => 'L\'adresse doit être une chaîne de caractères.',
        ];
    }
}
