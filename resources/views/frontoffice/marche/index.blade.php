@extends('frontoffice.app')

@push('style')
<style>
  .section-padding { padding: 60px 0; }
  .card-hover { transition: transform .25s, box-shadow .25s; }
  .card-hover:hover { transform: translateY(-3px); box-shadow: 0 1rem 2rem rgba(0,0,0,.1); }
</style>
@endpush

@section('content')
<section class="section-padding">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h3 mb-0">Marchés</h1>
      <a href="{{ route('frontoffice') }}" class="btn btn-sm btn-outline-secondary">Accueil</a>
    </div>

    <form method="GET" class="card mb-4 p-3">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Recherche</label>
          <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Vanille, ...">
        </div>
        <div class="col-md-3">
          <label class="form-label">Produit</label>
          <select name="produit" class="form-select">
            <option value="">Tous</option>
            @foreach($produits as $p)
              <option value="{{ $p }}" @selected(request('produit')===$p)>{{ $p }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Date de</label>
          <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">à</label>
          <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">Prix min</label>
          <input type="number" step="0.01" name="min_prix" value="{{ request('min_prix') }}" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">Prix max</label>
          <input type="number" step="0.01" name="max_prix" value="{{ request('max_prix') }}" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label">Disponibilité min</label>
          <input type="number" name="disponibilite_min" value="{{ request('disponibilite_min') }}" class="form-control">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button class="btn btn-warning me-2">Filtrer</button>
          <a href="{{ route('front.marche.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
        </div>
      </div>
    </form>

    <div class="row g-4">
      @forelse($marches as $m)
        <div class="col-md-6 col-lg-4">
          <div class="card card-hover h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <h5 class="card-title mb-1">{{ $m->produit }}</h5>
                <span class="badge bg-light text-dark">{{ \Carbon\Carbon::parse($m->date)->translatedFormat('d M Y') }}</span>
              </div>
              <p class="mb-1 text-muted">Prix: <strong>{{ number_format($m->prix,2,',',' ') }}</strong></p>
              <p class="mb-0 text-muted">Disponibilité: {{ $m->disponibilite ?? '—' }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-light border">Aucun résultat.</div>
        </div>
      @endforelse
    </div>

    <div class="mt-4">
      {{ $marches->links() }}
    </div>
  </div>
</section>
@endsection
