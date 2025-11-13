<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntrepriseExportatriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom'             => ['required', 'string', 'max:255'],
            'raison_sociale'  => ['required', 'string', 'max:255'],
            'pays'            => ['nullable', 'string', 'max:255'],
            'adresse'         => ['nullable', 'string', 'max:255'],
            'responsable'     => ['nullable', 'string', 'max:255'],
            'email'           => ['nullable', 'email:rfc', 'max:255'],
            'telephone'       => ['nullable', 'string', 'max:30'],
            'activite'        => ['nullable', 'string'],
            'description'     => ['nullable', 'string'],
        ];
    }
}
