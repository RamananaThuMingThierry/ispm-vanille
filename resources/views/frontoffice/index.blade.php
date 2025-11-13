@extends('frontoffice.app')

@push('style')
    <style>
        .nav-link.text-warning:hover {
            background: linear-gradient(90deg, #ffc107, #146e3c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: background 0.4s ease;
        }

        html {
            scroll-behavior: smooth;
        }

        .nav-link:hover {
            color: #ffc107 !important;
        }

        #heroCarousel .hero-slide-img {
            height: 80vh;
            object-fit: cover;
            object-position: center;
        }

        .carousel-caption {
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
        }

        .divider {
            width: 60px;
            height: 4px;
            background: #ffc107;
            border-radius: 2px;
        }

        .section-padding {
            padding: 80px 0;
        }

        .section-light {
            background: #f8f9fa;
        }

        .card-hover {
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, .12);
        }

        #scrollToTopBtn {
            position: fixed;
            bottom: 30px;
            right: 20px;
            display: none;
            z-index: 9999;
            width: 48px;
            height: 48px;
            font-size: 18px;
            justify-content: center;
            align-items: center;
        }

        #scrollToTopBtn:hover {
            background-color: #c82333;
        }

        .custom-tooltip {
            --bs-tooltip-bg: #ffc107;
            --bs-tooltip-color: black;
            font-weight: bold;
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .fade-in-up.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Contact section */
        .contact-card {
            border-radius: 1rem;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .contact-card-left {
            background: radial-gradient(circle at top left, #198754, #146e3c);
            color: #fff;
        }

        .contact-icon-circle {
            width: 48px;
            height: 48px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, .15);
        }

        /* Footer */
        footer {
            background: #121212;
            color: #ddd;
        }

        footer a {
            color: #aaa;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        /* Section producteurs sur image */
        #producteurs {
            position: relative;
            background-image: url('{{ asset(config('public_path.public_path') . 'images/V6.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        #producteurs::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
        }

        #producteurs .container {
            position: relative;
            z-index: 1;
        }

        #producteurs .card {
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
@endpush

@section('content')

    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold gwendolyn-bold" href="#">
                <img src="{{ asset(config('public_path.public_path') . 'utiles/logo.png') }}" alt="ISPM"
                    style="width: 50px; height: 50px;">
                Vanille
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="mainNav" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#marche">Marchés</a></li>
                    <li class="nav-item"><a class="nav-link" href="#producteurs">Producteurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#entreprises">Entreprises</a></li>
                    <li class="nav-item"><a class="nav-link" href="#actualites">Actualités</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link text-success" href="{{ route('login') }}">Se connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- HERO / CAROUSEL --}}
    <section id="hero" class="position-relative">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($slides ?? [] as $i => $slide)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                        <img src="{{ $slide['image'] }}" class="d-block w-100 hero-slide-img"
                            alt="{{ $slide['alt'] ?? 'Hero' }}">
                        <div class="carousel-caption text-start">
                            <div class="container">
                                <div class="col-12 col-lg-6">
                                    <span class="badge bg-warning text-dark mb-3">
                                        {{ $slide['badge'] ?? 'Marché agricole' }}
                                    </span>
                                    <h1 class="display-5 fw-bold  gwendolyn-bold">
                                        {{ $slide['title'] ?? 'Valorisons la filière' }}
                                    </h1>
                                    <p class="lead">
                                        {{ $slide['subtitle'] ?? 'Suivez les prix, découvrez les producteurs et connectez-vous aux entreprises.' }}
                                    </p>
                                    <a href="#marche" class="btn btn-warning text-dark me-2">Voir les marchés</a>
                                    <a href="#producteurs" class="btn btn-outline-light">Trouver des producteurs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </section>

    {{-- VALEUR / STATS --}}
    <section class="section-padding section-light">
        <div class="container">
            <div class="row text-center mb-4">
                <h2 class="fw-bold fade-in-up gwendolyn-bold">Un écosystème simple et transparent</h2>
                <div class="mx-auto divider my-3"></div>
                <p class="text-muted fade-in-up">
                    Données de marché, mise en relation et actualités du secteur.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <div class="card card-hover h-100 text-center p-3">
                        <div class="fs-1">🌾</div>
                        <div class="fw-bold mt-2">Producteurs</div>
                        <div class="text-muted">
                            {{ number_format($metrics['producteurs'] ?? 0, 0, ',', ' ') }}
                        </div>
                        <small class="text-muted">acteurs référencés</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card card-hover h-100 text-center p-3">
                        <div class="fs-1">📈</div>
                        <div class="fw-bold mt-2">Marchés</div>
                        <div class="text-muted">
                            {{ number_format($metrics['marches'] ?? 0, 0, ',', ' ') }}
                        </div>
                        <small class="text-muted">enregistrements de prix</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card card-hover h-100 text-center p-3">
                        <div class="fs-1">🚢</div>
                        <div class="fw-bold mt-2">Exportatrices</div>
                        <div class="text-muted">
                            {{ number_format($metrics['exportatrices'] ?? 0, 0, ',', ' ') }}
                        </div>
                        <small class="text-muted">entreprises</small>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card card-hover h-100 text-center p-3">
                        <div class="fs-1">🛬</div>
                        <div class="fw-bold mt-2">Importatrices</div>
                        <div class="text-muted">
                            {{ number_format($metrics['importatrices'] ?? 0, 0, ',', ' ') }}
                        </div>
                        <small class="text-muted">partenaires potentiels</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MARCHÉS --}}
    <section id="marche" class="section-padding" style="background-color: rgb(113, 139, 93);">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h2 class="fw-bold mb-0 gwendolyn-bold text-white">Tendances du marché</h2>
                    <div class="divider my-3"></div>
                    <p class="mb-0 small text-white">
                        Derniers relevés de prix et disponibilités par produit et par marché.
                    </p>
                </div>
                <a href="{{ route('front.marche.index') }}" class="btn btn-danger btn-sm">
                    Tout voir
                </a>
            </div>

            <div class="row g-4">
                @forelse(($marches ?? []) as $m)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-hover h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h5 class="card-title mb-0">
                                        {{ optional($m->produit)->nom ?? 'Produit non défini' }}
                                    </h5>
                                    <span class="badge bg-warning text-dark">
                                        {{ \Carbon\Carbon::parse($m->date)->locale('fr')->translatedFormat('d M Y') }}
                                    </span>
                                </div>

                                @if ($m->marche)
                                    <p class="mb-1 small text-muted">
                                        Marché : <strong>{{ $m->marche }}</strong>
                                    </p>
                                @endif

                                <p class="mb-1 text-muted">
                                    Prix :
                                    <strong>
                                        {{ number_format($m->prix, 2, ',', ' ') }}
                                        {{ $m->monnaie ?? 'MGA' }}
                                    </strong>
                                    <span class="small text-muted">
                                        / {{ optional($m->produit)->unite ?? 'unité' }}
                                    </span>
                                </p>

                                <p class="mb-0 small text-muted">
                                    Disponibilité :
                                    <strong>{{ $m->disponibilite ?? '—' }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border">
                            Aucune donnée marché pour le moment.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- PRODUCTEURS --}}
    <section id="producteurs" class="section-padding">
        <div class="container">
            <div class="row align-items-end mb-3">
                <div class="col">
                    <h2 class="fw-bold mb-0 text-white gwendolyn-bold">Producteurs à découvrir</h2>
                    <div class="divider my-3"></div>
                    <p class="text-light small mb-0">
                        Identifiez rapidement des producteurs, leurs localisations et les quantités disponibles.
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('front.producteurs.index') }}" class="btn btn-outline-light btn-sm">
                        Voir tous
                    </a>
                </div>
            </div>

            <div class="row g-4">
                @forelse(($producteurs ?? []) as $p)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-hover h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-1">
                                    {{ $p->nom }} {{ $p->prenom }}
                                </h5>
                                <p class="text-muted mb-1 small">
                                    {{ $p->fokontany ? $p->fokontany . ' - ' : '' }}
                                    {{ $p->commune ?? ($p->district ?? ($p->region ?? 'Localisation non renseignée')) }}
                                </p>
                                <p class="mb-0 small">
                                    Quantité disponible :
                                    <strong>{{ $p->quantite ?? '—' }}</strong>
                                </p>
                            </div>
                            @if ($p->telephone || $p->email)
                                <div class="card-footer small d-flex gap-2 flex-wrap">
                                    @if ($p->telephone)
                                        <a href="tel:{{ $p->telephone }}" class="link-dark text-decoration-none">
                                            📞 {{ $p->telephone }}
                                        </a>
                                    @endif
                                    @if ($p->email)
                                        <span>•</span>
                                        <a href="mailto:{{ $p->email }}" class="link-dark text-decoration-none">
                                            ✉️ {{ $p->email }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border">
                            Aucun producteur affiché.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ENTREPRISES --}}
    <section id="entreprises" class="section-padding">
        <div class="container">
            <div class="row align-items-end mb-3">
                <div class="col">
                    <h2 class="fw-bold mb-0  gwendolyn-bold">Entreprises exportatrices & importatrices</h2>
                    <div class="divider my-3"></div>
                    <p class="text-muted small mb-0">
                        Repérez rapidement les acteurs économiques de la filière, côté export et import.
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('front.entreprises.index') }}"
                        class="btn btn-outline-secondary btn-sm">Répertoire</a>
                </div>
            </div>

            <div class="row g-4">
                @forelse(($exportatrices ?? []) as $e)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-hover h-100">
                            <div class="card-body">
                                <span class="badge bg-success mb-2">Export</span>
                                <h5 class="card-title mb-1">{{ $e->nom }}</h5>
                                <p class="text-muted mb-1 small">{{ $e->pays ?? 'Pays non renseigné' }}</p>
                                <p class="small mb-0">
                                    {{ \Illuminate\Support\Str::limit($e->description, 120) ?: 'Aucune description.' }}
                                </p>
                            </div>
                            <div class="card-footer small d-flex gap-2 flex-wrap">
                                @if ($e->telephone)
                                    <a href="tel:{{ $e->telephone }}" class="link-dark text-decoration-none">
                                        📞 {{ $e->telephone }}
                                    </a>
                                @endif
                                @if ($e->email)
                                    <span>•</span>
                                    <a href="mailto:{{ $e->email }}" class="link-dark text-decoration-none">
                                        ✉️ {{ $e->email }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

                @forelse(($importatrices ?? []) as $i)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-hover h-100">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">Import</span>
                                <h5 class="card-title mb-1">{{ $i->nom }}</h5>
                                <p class="text-muted mb-1 small">{{ $i->pays ?? 'Pays non renseigné' }}</p>
                                <p class="small mb-0">
                                    {{ \Illuminate\Support\Str::limit($i->description, 120) ?: 'Aucune description.' }}
                                </p>
                            </div>
                            <div class="card-footer small d-flex gap-2 flex-wrap">
                                @if ($i->telephone)
                                    <a href="tel:{{ $i->telephone }}" class="link-dark text-decoration-none">
                                        📞 {{ $i->telephone }}
                                    </a>
                                @endif
                                @if ($i->email)
                                    <span>•</span>
                                    <a href="mailto:{{ $i->email }}" class="link-dark text-decoration-none">
                                        ✉️ {{ $i->email }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>

    {{-- ACTUALITÉS --}}
    <section id="actualites" class="section-padding" style="background-color: rgb(166, 146, 112);">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h2 class="fw-bold mb-0 gwendolyn-bold">Actualités</h2>
                    <div class="divider my-3"></div>
                    <p class="text-muted small mb-0">
                        Suivez les informations, réformes et événements autour de la filière.
                    </p>
                </div>
                <a href="{{ route('front.actualites.index') }}" class="btn btn-warning btn-sm">Toutes les
                    actus</a>
            </div>

            <div class="row g-4">
                @forelse(($actualites ?? []) as $a)
                    <div class="col-md-6 col-lg-4">
                        <article class="card card-hover h-100">
                            @if ($a->image)
                                <img src="{{ asset($a->image) }}" alt="{{ $a->titre }}" class="card-img-top"
                                    style="height:180px; object-fit:cover;">
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h5 class="card-title mb-0">{{ $a->titre }}</h5>
                                    @if ($a->ala_une)
                                        <span class="badge bg-warning text-dark">À la une</span>
                                    @endif
                                </div>
                                <p class="small text-muted mb-1">
                                    {{ $a->publie_le ? $a->publie_le->locale('fr')->translatedFormat('d M Y') : '' }}
                                </p>
                                <p class="card-text text-muted small mb-2">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($a->contenu), 120) }}
                                </p>
                                <a href="{{ route('front.actualites.show', $a->id) }}" class="stretched-link">
                                    Lire l’article
                                </a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border">
                            Aucune actualité publiée.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="section-padding">
        <div class="container">
            <div class="row text-center mb-4">
                <h2 class="fw-bold  gwendolyn-bold">Questions fréquentes</h2>
                <div class="divider mx-auto my-3"></div>
            </div>
            <div class="accordion" id="faqAcc">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1">
                            Comment sont collectés les prix ?
                        </button>
                    </h2>
                    <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqAcc">
                        <div class="accordion-body">
                            Données issues de relevés terrain et de contributions vérifiées.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#a2">
                            Comment contacter un producteur ?
                        </button>
                    </h2>
                    <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                        <div class="accordion-body">
                            Utilisez les coordonnées affichées sur sa fiche ou le formulaire de contact.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTACT MODERNE --}}
    <section id="contact" class="section-padding" style="background-color: rgb(43, 84, 43);">
        <div class="container">
            <div class="row mb-4 text-center">
                <h2 class="fw-bold  gwendolyn-bold text-white">Contact & Retour d’expérience</h2>
                <div class="divider mx-auto my-3"></div>
                <p class="text-white mb-0">
                    Une question, une suggestion, un besoin spécifique ? Écrivez-nous, nous vous répondrons dans les
                    meilleurs délais.
                </p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row contact-card">
                        {{-- Col gauche : infos CCI --}}
                        <div class="col-md-5 contact-card-left p-4 d-flex flex-column justify-content-between">
                            <div>
                                <h4 class="fw-bold mb-3">Restons en contact</h4>
                                <p class="mb-4">
                                    Plateforme portée par la Chambre de Commerce et d’Industrie d’Antananarivo.
                                </p>

                                {{-- Adresse officielle --}}
                                <div class="d-flex align-items-start mb-3">
                                    <div class="contact-icon-circle me-3">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold mb-0">Adresse</div>
                                        <small>
                                            20, rue Henry RAZANATSEHENO Antaninarenina,<br>
                                            Antananarivo 101 – Madagascar – BP 166
                                        </small>
                                    </div>
                                </div>

                                {{-- Site web --}}
                                <div class="d-flex align-items-start mb-3">
                                    <div class="contact-icon-circle me-3">
                                        <i class="bi bi-globe"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold mb-0">Site web</div>
                                        <small>
                                            <a class="text-white text-decoration-underline" href="https://www.cci.mg"
                                                target="_blank" rel="noopener">
                                                www.cci.mg
                                            </a>
                                        </small>
                                    </div>
                                </div>

                                {{-- Facebook --}}
                                <div class="d-flex align-items-start">
                                    <div class="contact-icon-circle me-3">
                                        <i class="bi bi-facebook"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold mb-0">Facebook</div>
                                        <small>
                                            <a class="text-white text-decoration-underline"
                                                href="https://www.facebook.com" target="_blank" rel="noopener">
                                                Chambre de Commerce et d’Industrie d’Antananarivo
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 small">
                                <span class="opacity-75">Restez connectés :</span>
                                <div class="mt-2 d-flex gap-2">
                                    <a href="https://www.cci.mg" target="_blank" rel="noopener"
                                        class="btn btn-sm btn-outline-light rounded-circle px-2" title="Site web">
                                        <i class="bi bi-globe"></i>
                                    </a>
                                    <a href="https://www.facebook.com" target="_blank" rel="noopener"
                                        class="btn btn-sm btn-outline-light rounded-circle px-2" title="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Col droite : formulaire --}}
                        <div class="col-md-7 p-4 bg-white">
                            @if (session('success'))
                                <div class="alert alert-success mb-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger mb-3">
                                    Merci de corriger les erreurs ci-dessous.
                                </div>
                            @endif

                            <form method="POST" action="{{ route('contact.send') }}">
                                @csrf
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Nom complet *</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Téléphone</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                            class="form-control @error('phone') is-invalid @enderror">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Objet</label>
                                        <select class="form-select @error('subject') is-invalid @enderror" name="subject">
                                            <option value="">Choisir...</option>
                                            <option value="info" {{ old('subject') === 'info' ? 'selected' : '' }}>
                                                Demande d’information
                                            </option>
                                            <option value="partenariat"
                                                {{ old('subject') === 'partenariat' ? 'selected' : '' }}>
                                                Partenariat
                                            </option>
                                            <option value="support" {{ old('subject') === 'support' ? 'selected' : '' }}>
                                                Support technique
                                            </option>
                                        </select>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Message *</label>
                                        <textarea name="message" rows="4" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <small class="text-muted">* Champs obligatoires</small>
                                        <button type="submit" class="btn btn-success">
                                            Envoyer le message
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div><!-- /.contact-card -->
                </div>
            </div>
        </div>
    </section>

    {{-- Back to top --}}
    <button id="scrollToTopBtn" class="btn btn-danger rounded-circle d-flex" aria-label="Retour en haut">
        ↑
    </button>

    {{-- FOOTER --}}
    <footer class="pt-4 pb-3">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3 gwendolyn-bold">Vanille</h5>
                    <p class="small mb-2">
                        Plateforme de suivi des marchés et de mise en relation
                        des acteurs de la filière vanille.
                    </p>

                    <p class="small mb-1">
                        <strong>Adresse :</strong><br>
                        20, rue Henry RAZANATSEHENO Antaninarenina,<br>
                        Antananarivo 101 – Madagascar – BP 166
                    </p>

                    <p class="small mb-1">
                        <strong>Site :</strong>
                        <a href="https://www.cci.mg" target="_blank" rel="noopener">www.cci.mg</a>
                    </p>

                    <p class="small mb-2">
                        <strong>Facebook :</strong>
                        Chambre de Commerce et d’Industrie d’Antananarivo
                    </p>

                    <p class="small mb-0">
                        © {{ date('Y') }} Vanille — Tous droits réservés.
                    </p>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-semibold mb-3">Navigation</h6>
                    <ul class="list-unstyled small">
                        <li><a href="#marche">Marchés</a></li>
                        <li><a href="#producteurs">Producteurs</a></li>
                        <li><a href="#entreprises">Entreprises</a></li>
                        <li><a href="#actualites">Actualités</a></li>
                        <li><a href="#faq">FAQ</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h6 class="fw-semibold mb-3">Newsletter</h6>
                    <p class="small">
                        Recevez les principales tendances de prix et les actualités de la filière.
                    </p>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control form-control-sm" placeholder="Votre email">
                        <button class="btn btn-warning btn-sm" type="button">S’inscrire</button>
                    </form>
                </div>
            </div>
        </div>
    </footer>

@endsection

@push('script')
    <script>
        // Tooltips
        [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].forEach(el =>
            new bootstrap.Tooltip(el, {
                customClass: 'custom-tooltip'
            })
        );

        // Back to top button
        const topBtn = document.getElementById('scrollToTopBtn');
        window.addEventListener('scroll', () => {
            topBtn.style.display = (window.scrollY > 300) ? 'flex' : 'none';
        });
        topBtn.addEventListener('click', () =>
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            })
        );

        // Reveal on scroll
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('is-visible');
            });
        }, {
            threshold: .2
        });

        document.querySelectorAll('.fade-in-up, .card-hover').forEach(el => io.observe(el));
    </script>
@endpush
