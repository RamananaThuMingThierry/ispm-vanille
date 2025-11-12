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
            'date'          => ['required', 'date'],
            'produit'       => ['required', 'string', 'max:255'],
            'prix'          => ['required', 'numeric', 'min:0'],
            'disponibilite' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
