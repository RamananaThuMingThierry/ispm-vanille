<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chemins des images
    |--------------------------------------------------------------------------
    |
    | Ces chemins sont définis en fonction de l'environnement.
    | La variable 'public_path' renverra le bon chemin pour les images.
    |
    */

    'public_path' => env('APP_ENV') === 'prod' 
        ? 'public/' 
        : '',

];
