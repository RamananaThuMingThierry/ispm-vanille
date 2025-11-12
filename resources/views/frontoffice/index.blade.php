@extends('frontoffice.app')

@push('style')
    <style>
        .nav-link.text-warning:hover {
            background: linear-gradient(90deg, #ffc107, #146e3c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: background 0.4s ease;
        }

        html { scroll-behavior: smooth; }
        .nav-link:hover { color: #ffc107 !important; }
        #heroCarousel .hero-slide-img { height: 80vh; object-fit: cover; object-position: center; }

        .carousel-caption { top:0; bottom:0; left:0; right:0; display:flex; align-items:center; }
        .divider { width:60px; height:4px; background:#ffc107; border-radius: 2px; }

        .section-padding { padding: 80px 0; }
        .section-light { background: #f8f9fa; }
        .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 1rem 2rem rgba(0,0,0,.12); }

        #scrollToTopBtn {
            position: fixed; bottom: 30px; right: 20px; display: none; z-index: 9999;
            width: 48px; height: 48px; font-size: 18px; justify-content: center; align-items: center;
        }
        #scrollToTopBtn:hover { background-color: #c82333; }

        .custom-tooltip { --bs-tooltip-bg:#ffc107; --bs-tooltip-color:black; font-weight: bold; }
        .fade-in-up { opacity:0; transform: translateY(16px); transition: opacity .6s ease, transform .6s ease; }
        .fade-in-up.is-visible { opacity:1; transform: translateY(0); }
    </style>
@endpush

@section('content')

{{-- NAVBAR (option: si ta layout n’en fournit pas) --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold gwendolyn-bold" href="#"><img src="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" alt="ISPM" style="width: 50px; height: 50px;"> Vanille</a>
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
      </ul>
    </div>
  </div>
</nav>

{{-- HERO / CAROUSEL --}}
<section id="hero" class="position-relative">
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      @foreach(($slides ?? []) as $i => $slide)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
          <img src="{{ $slide['image'] }}" class="d-block w-100 hero-slide-img" alt="{{ $slide['alt'] ?? 'Hero' }}">
          <div class="carousel-caption text-start">
            <div class="container">
              <div class="col-12 col-lg-6">
                <span class="badge bg-warning text-dark mb-3">{{ $slide['badge'] ?? 'Marché agricole' }}</span>
                <h1 class="display-5 fw-bold">{{ $slide['title'] ?? 'Valorisons la filière' }}</h1>
                <p class="lead">{{ $slide['subtitle'] ?? 'Suivez les prix, découvrez les producteurs et connectez-vous aux entreprises.' }}</p>
                <a href="#marche" class="btn btn-warning text-dark me-2">Voir les marchés</a>
                <a href="#producteurs" class="btn btn-outline-light">Trouver des producteurs</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Suivant</span>
    </button>
  </div>
</section>

{{-- VALEUR / STATS --}}
<section class="section-padding section-light">
  <div class="container">
    <div class="row text-center mb-4">
      <h2 class="fw-bold fade-in-up gwendolyn-bold">Un écosystème simple et transparent</h2>
      <div class="mx-auto divider my-3"></div>
      <p class="text-muted fade-in-up">Données de marché, mise en relation et actualités du secteur.</p>
    </div>

    <div class="row g-4">
      <div class="col-6 col-lg-3">
        <div class="card card-hover h-100 text-center p-3">
          <div class="fs-1">🌾</div>
          <div class="fw-bold mt-2">Producteurs</div>
          <div class="text-muted">{{ number_format($metrics['producteurs'] ?? 0, 0, ',', ' ') }}</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card card-hover h-100 text-center p-3">
          <div class="fs-1">📈</div>
          <div class="fw-bold mt-2">Marchés</div>
          <div class="text-muted">{{ number_format($metrics['marches'] ?? 0, 0, ',', ' ') }}</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card card-hover h-100 text-center p-3">
          <div class="fs-1">🚢</div>
          <div class="fw-bold mt-2">Exportatrices</div>
          <div class="text-muted">{{ number_format($metrics['exportatrices'] ?? 0, 0, ',', ' ') }}</div>
        </div>
      </div>
      <div class="col-6 col-lg-3">
        <div class="card card-hover h-100 text-center p-3">
          <div class="fs-1">🛬</div>
          <div class="fw-bold mt-2">Importatrices</div>
          <div class="text-muted">{{ number_format($metrics['importatrices'] ?? 0, 0, ',', ' ') }}</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- MARCHÉS --}}
<section id="marche" class="section-padding">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h2 class="fw-bold mb-0">Tendances du marché</h2>
        <div class="divider my-3"></div>
      </div>
      <a href="{{ route('front.marche.index') }}" class="btn btn-outline-secondary btn-sm">Tout voir</a>
    </div>

    <div class="row g-4">
      @forelse(($marches ?? []) as $m)
        <div class="col-md-6 col-lg-4">
          <div class="card card-hover h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <h5 class="card-title mb-1">{{ $m->produit }}</h5>
                <span class="badge bg-warning text-dark">{{ \Carbon\Carbon::parse($m->date)->translatedFormat('d M Y') }}</span>
              </div>
              <p class="mb-1 text-muted">Prix: <strong>{{ number_format($m->prix, 2, ',', ' ') }} Ar</strong></p>
              <p class="mb-0 text-muted">Disponibilité: {{ $m->disponibilite ?? '—' }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><div class="alert alert-light border">Aucune donnée marché pour le moment.</div></div>
      @endforelse
    </div>
  </div>
</section>

{{-- PRODUCTEURS --}}
<section id="producteurs" class="section-padding section-light">
  <div class="container">
    <div class="row align-items-end mb-3">
      <div class="col">
        <h2 class="fw-bold mb-0">Producteurs à découvrir</h2>
        <div class="divider my-3"></div>
      </div>
      <div class="col-auto">
        <a href="{{ route('front.producteurs.index') }}" class="btn btn-outline-secondary btn-sm">Voir tous</a>
      </div>
    </div>

    <div class="row g-4">
      @forelse(($producteurs ?? []) as $p)
        <div class="col-md-6 col-lg-4">
          <div class="card card-hover h-100">
            <div class="card-body">
              <h5 class="card-title mb-1">{{ $p->nom }} {{ $p->prenom }}</h5>
              <p class="text-muted mb-2">{{ $p->commune ?? $p->region ?? '—' }}</p>
              <p class="mb-0 small">Quantité dispo : <strong>{{ $p->quantite ?? '—' }}</strong></p>
            </div>
            @if($p->telephone || $p->email)
            <div class="card-footer small d-flex gap-2">
              @if($p->telephone)<a href="tel:{{ $p->telephone }}" class="link-dark text-decoration-none">📞 {{ $p->telephone }}</a>@endif
              @if($p->email)<span>•</span><a href="mailto:{{ $p->email }}" class="link-dark text-decoration-none">✉️ {{ $p->email }}</a>@endif
            </div>
            @endif
          </div>
        </div>
      @empty
        <div class="col-12"><div class="alert alert-light border">Aucun producteur affiché.</div></div>
      @endforelse
    </div>
  </div>
</section>

{{-- ENTREPRISES --}}
<section id="entreprises" class="section-padding">
  <div class="container">
    <div class="row align-items-end mb-3">
      <div class="col">
        <h2 class="fw-bold mb-0">Entreprises exportatrices & importatrices</h2>
        <div class="divider my-3"></div>
      </div>
      <div class="col-auto">
        <a href="{{ route('front.entreprises.index') }}" class="btn btn-outline-secondary btn-sm">Répertoire</a>
      </div>
    </div>

    <div class="row g-4">
      @forelse(($exportatrices ?? []) as $e)
        <div class="col-md-6 col-lg-4">
          <div class="card card-hover h-100">
            <div class="card-body">
              <span class="badge bg-success mb-2">Export</span>
              <h5 class="card-title mb-1">{{ $e->nom }}</h5>
              <p class="text-muted mb-2">{{ $e->pays ?? '—' }}</p>
              <p class="small mb-0">{{ Str::limit($e->description, 120) }}</p>
            </div>
            <div class="card-footer small d-flex gap-2">
              @if($e->telephone) <a href="tel:{{ $e->telephone }}" class="link-dark text-decoration-none">📞 {{ $e->telephone }}</a> @endif
              @if($e->email) <span>•</span> <a href="mailto:{{ $e->email }}" class="link-dark text-decoration-none">✉️ {{ $e->email }}</a> @endif
            </div>
          </div>
        </div>
      @empty @endforelse

      @forelse(($importatrices ?? []) as $i)
        <div class="col-md-6 col-lg-4">
          <div class="card card-hover h-100">
            <div class="card-body">
              <span class="badge bg-primary mb-2">Import</span>
              <h5 class="card-title mb-1">{{ $i->nom }}</h5>
              <p class="text-muted mb-2">{{ $i->pays ?? '—' }}</p>
              <p class="small mb-0">{{ Str::limit($i->description, 120) }}</p>
            </div>
            <div class="card-footer small d-flex gap-2">
              @if($i->telephone) <a href="tel:{{ $i->telephone }}" class="link-dark text-decoration-none">📞 {{ $i->telephone }}</a> @endif
              @if($i->email) <span>•</span> <a href="mailto:{{ $i->email }}" class="link-dark text-decoration-none">✉️ {{ $i->email }}</a> @endif
            </div>
          </div>
        </div>
      @empty @endforelse
    </div>
  </div>
</section>

{{-- ACTUALITÉS --}}
<section id="actualites" class="section-padding section-light">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h2 class="fw-bold mb-0">Actualités</h2>
        <div class="divider my-3"></div>
      </div>
      <a href="{{ route('front.actualites.index') }}" class="btn btn-outline-secondary btn-sm">Toutes les actus</a>
    </div>

    <div class="row g-4">
      @forelse(($actualites ?? []) as $a)
        <div class="col-md-6 col-lg-4">
          <article class="card card-hover h-100">
            @if($a->image)
              <img src="{{ asset($a->image) }}" alt="{{ $a->titre }}" class="card-img-top" style="height:180px; object-fit:cover;">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $a->titre }}</h5>
              <p class="card-text text-muted small">{{ Str::limit(strip_tags($a->contenu), 120) }}</p>
              <a href="{{ route('front.actualites.show', $a->id) }}" class="stretched-link">Lire</a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12"><div class="alert alert-light border">Aucune actualité publiée.</div></div>
      @endforelse
    </div>
  </div>
</section>

{{-- FAQ --}}
<section id="faq" class="section-padding">
  <div class="container">
    <div class="row text-center mb-4">
      <h2 class="fw-bold">Questions fréquentes</h2>
      <div class="divider mx-auto my-3"></div>
    </div>
    <div class="accordion" id="faqAcc">
      <div class="accordion-item">
        <h2 class="accordion-header" id="q1">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1">Comment sont collectés les prix ?</button>
        </h2>
        <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqAcc">
          <div class="accordion-body">Données issues de relevés terrain et de contributions vérifiées.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">Comment contacter un producteur ?</button>
        </h2>
        <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
          <div class="accordion-body">Utilisez les coordonnées affichées sur sa fiche ou le formulaire de contact.</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Back to top --}}
<button id="scrollToTopBtn" class="btn btn-danger rounded-circle d-flex" aria-label="Retour en haut">
  ↑
</button>

@endsection

@push('script')
<script>
  // Tooltips
  [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].forEach(el => new bootstrap.Tooltip(el, { customClass: 'custom-tooltip' }));

  // Back to top button
  const topBtn = document.getElementById('scrollToTopBtn');
  window.addEventListener('scroll', () => {
    topBtn.style.display = (window.scrollY > 300) ? 'flex' : 'none';
  });
  topBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  // Reveal on scroll
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('is-visible'); });
  }, { threshold: .2 });

  document.querySelectorAll('.fade-in-up, .card-hover').forEach(el => io.observe(el));
</script>
@endpush
