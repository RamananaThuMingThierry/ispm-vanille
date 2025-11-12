<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ProducteurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $producteurId = null;

        if ($this->route('producteur')) {
            try {
                $producteurId = Crypt::decryptString($this->route('producteur'));
            } catch (DecryptException $e) {
                $producteurId = null;
            }
        }

        return [
            'nom'       => ['required', 'string', 'max:255'],
            'prenom'    => ['nullable', 'string', 'max:255'],
            'adresse'   => ['nullable', 'string', 'max:255'],
            'quantite'  => ['nullable', 'numeric', 'min:0'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'email'     => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('producteurs', 'email')->ignore($producteurId),
            ],
            'fokontany' => ['nullable', 'string', 'max:255'],
            'commune'   => ['nullable', 'string', 'max:255'],
            'district'  => ['nullable', 'string', 'max:255'],
            'region'    => ['nullable', 'string', 'max:255'],
        ];
    }
}
