<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnonceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorie'     => ['required', Rule::in(['offre', 'demande'])],
            'produit_id'    => ['required', 'exists:produits,id'],
            'quantite'      => ['nullable', 'numeric', 'min:0'],
            'prix_unitaire' => ['nullable', 'numeric', 'min:0'],
            'commune'       => ['nullable', 'string', 'max:255'],
            'district'      => ['nullable', 'string', 'max:255'],
            'region'        => ['nullable', 'string', 'max:255'],
            'contact'       => ['nullable', 'string', 'max:255'],
        ];
    }
}
