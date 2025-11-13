<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $produitId = null;

        $encryptedId = $this->route('produit') ?? $this->route('id');

        if ($encryptedId) {
            try {
                $produitId = Crypt::decryptString($encryptedId);
            } catch (DecryptException $e) {
            }
        }

        return [
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produits', 'nom')->ignore($produitId),
            ],
            'unite' => ['nullable', 'string', 'max:50'],
        ];
    }
}
