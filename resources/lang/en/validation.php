<?php

return [
    'required' => 'The :attribute field is required.',
    'image' => 'The :attribute must be an image.',
    'mimes' => 'The :attribute must be a file of type: :values.',
    'in' => 'The selected :attribute is invalid.',
    'email' => 'The :attribute must be a valid email address.',
    'string' => 'The :attribute must be a string.',
    'max' => [
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'image' => 'The :attribute must be an image.',
    'mimes' => 'The :attribute must be a file of type: :values.',   
    'testimonial' => [
        'name_required' => 'The name is required.',
        'name_string' => 'The name must be a string.',
        'name_max' => 'The name may not be greater than 255 characters.',

        'message_required' => 'The message is required.',
        'message_string' => 'The message must be a string.',

        'rating_required' => 'The rating is required.',
        'rating_integer' => 'The rating must be an integer.',
        'rating_between' => 'The rating must be between 1 and 5.',

        'status_required' => 'The status is required.',
        'status_in' => 'The selected status is invalid.',

        'image_image' => 'The file must be an image.',
        'image_mimes' => 'The image must be a file of type: jpeg, png, jpg, webp.',
        'image_max' => 'The image may not be greater than 2MB.',
    ],
];
