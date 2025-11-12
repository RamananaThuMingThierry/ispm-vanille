<?php

return [
    'required' => 'Le champ :attribute est obligatoire.',
    'image' => 'Le champ :attribute doit être une image.',
    'mimes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'max' => [
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
    ],

    'testimonial' => [
        'name_required' => 'Le nom est requis.',
        'name_string' => 'Le nom doit être une chaîne de caractères.',
        'name_max' => 'Le nom ne peut pas dépasser 255 caractères.',

        'message_required' => 'Le message est requis.',
        'message_string' => 'Le message doit être une chaîne de caractères.',

        'rating_required' => 'La note est requise.',
        'rating_integer' => 'La note doit être un nombre entier.',
        'rating_between' => 'La note doit être comprise entre 1 et 5.',

        'status_required' => 'Le statut est requis.',
        'status_in' => 'Le statut sélectionné est invalide.',

        'image_image' => 'Le fichier doit être une image.',
        'image_mimes' => 'L’image doit être de type : jpeg, png, jpg, webp.',
        'image_max' => 'L’image ne peut pas dépasser 2 Mo.',
    ],
];
