<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'           => ['required', 'date'],
            'produit_id'     => ['required', 'exists:produits,id'],
            'marche'         => ['nullable', 'string', 'max:255'],
            'monnaie'        => ['nullable', 'string', 'size:3'],
            'source'         => ['nullable', 'string', 'max:255'],
            'prix'           => ['required', 'numeric', 'min:0'],
            'disponibilite'  => ['nullable', 'integer', 'min:0'],
        ];
    }

}
