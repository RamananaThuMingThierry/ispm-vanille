@php
    $isHome = request()->routeIs('frontoffice');
@endphp

<header class="bg-header fixed-top z-50">
    <div class="container-fluid px-4">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <!-- Logo -->
                <a href="{{ route('frontoffice') }}" class="navbar-brand fw-bold text-primary">
                    <img src="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" alt="Logo Agence" class="rounded-pill" alt="Logo" width="40" height="40">
                </a>

                <!-- Toggle button for mobile -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span id="navbarToggleIcon"><i class="fas fa-bars"></i></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
                    <ul class="navbar-nav gap-2 w-100 justify-content-center">
                        <li class="nav-item">
                            <a href="{{ route('frontoffice') }}"
                               class="nav-link {{ request()->routeIs('frontoffice') ? 'active fw-bold text-white' : 'text-dark' }}">
                                {{ __('nav.home') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=""
                               class="nav-link {{ request()->routeIs('tours') ? 'active fw-bold text-white' : 'text-dark' }}">
                                {{ __('nav.tours') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=""
                               class="nav-link">
                                {{ __('nav.testimonials') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ $isHome ? '#about' : route('frontoffice') . '#about' }}"
                               class="nav-link">
                                {{ __('nav.about') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ $isHome ? '#contact' : route('frontoffice') . '#contact' }}"
                               class="nav-link">
                                {{ __('nav.contact') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Language Selector -->
                <div class="dropdown lang-dropdown-mobile d-lg-block">
                    <button class="btn btn-outline-light text-dark btn-sm dropdown-toggle" type="button" id="langMenu" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        🌐 {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langMenu">
                        <li>
                            <a class="dropdown-item lang-change {{ app()->getLocale() === 'en' ? 'active' : '' }}" href="javascript:void(0);" data-lang="en">
                                <img src="{{ asset(config('public_path.public_path') .'img/icon_en.png') }}" width="22px"/>&nbsp;{{ __('lang.english') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item lang-change {{ app()->getLocale() === 'de' ? 'active' : '' }}" href="javascript:void(0);" data-lang="de">
                                <img src="{{ asset(config('public_path.public_path') .'img/icon_de.png') }}" width="22px"/>&nbsp;{{ __('lang.german') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item lang-change {{ app()->getLocale() === 'es' ? 'active' : '' }}" href="javascript:void(0);" data-lang="es">
                                <img src="{{ asset(config('public_path.public_path') .'img/icon_es.png') }}" width="22px"/>&nbsp;{{ __('lang.spanish') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item lang-change {{ app()->getLocale() === 'fr' ? 'active' : '' }}" href="javascript:void(0);" data-lang="fr">
                                <img src="{{ asset(config('public_path.public_path') .'img/icon_fr.png') }}" width="22px"/>&nbsp;{{ __('lang.french') }}
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</header>
