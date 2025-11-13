<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('actualite')?->id ?? $this->route('actualite');

        return [
            'titre'       => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', Rule::unique('actualites', 'slug')->ignore($id)],
            'contenu'     => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'statut'      => ['nullable', 'in:brouillon,publie'],
            'publie_le'   => ['nullable', 'date'],
            'ala_une'     => ['nullable', 'boolean'],
            'auteur_id'   => ['nullable', 'exists:users,id'],
        ];
    }
}
