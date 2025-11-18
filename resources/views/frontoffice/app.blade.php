<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <title>@yield('title','Plateforme Vanille – Madagascar')</title>

    <link rel="icon" href="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" type="image/png">

    {{-- SEO de base (thème vanille) --}}
    <meta name="description" content="@yield('meta_description', 'Plateforme dédiée à la vanille de Madagascar : prix du marché, disponibilité, producteurs locaux, entreprises exportatrices/importatrices et actualités de la filière (SAVA, Sambava, Antalaha, Andapa, Vohemar). Suivez les tendances et entrez en relation avec les acteurs de la chaîne de valeur.')">
    <meta name="keywords" content="@yield('meta_keywords', 'vanille Madagascar, prix vanille, marché vanille, producteurs vanille, export vanille, import vanille, SAVA, Sambava, Antalaha, Andapa, Vohemar, épices Madagascar, qualité vanille, traçabilité vanille')">
    <meta name="author" content="RAMANANA Thu Ming Thierry" />

    {{-- Open Graph / réseaux sociaux (optionnel mais utile) --}}
    <meta property="og:locale" content="fr_FR">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'Plateforme Vanille – Madagascar')">
    <meta property="og:description" content="@yield('og_description', 'Suivez les prix du marché de la vanille, découvrez les producteurs et connectez-vous aux entreprises de Madagascar.')">
    <meta property="og:image" content="@yield('og_image', asset(config('public_path.public_path').'utiles/logo.png'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="Plateforme Vanille">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Plateforme Vanille – Madagascar')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Prix, disponibilité, producteurs et actualités de la filière vanille à Madagascar.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset(config('public_path.public_path').'utiles/logo.png'))">

    @stack('style')
    @include('frontoffice.layouts.style')
</head>
<body>
    @yield('content')

    @include('frontoffice.layouts.script')
    @stack('script')
</body>
</html>
