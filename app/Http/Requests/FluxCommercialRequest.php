<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FluxCommercialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'       => ['required', Rule::in(['import', 'export'])],
            'produit_id' => ['required', 'exists:produits,id'],
            'annee'      => ['required', 'integer', 'min:1900', 'max:2100'],
            'quantite'   => ['nullable', 'numeric', 'min:0'],
            'valeur'     => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
