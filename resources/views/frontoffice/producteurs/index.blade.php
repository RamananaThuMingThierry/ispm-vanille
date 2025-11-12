@extends('frontoffice.app')

@push('style')
<style>
  .section-padding { padding: 60px 0; }
  .sidebar { position: sticky; top: 80px; }
</style>
@endpush

@section('content')
<section class="section-padding">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 mb-4">
        <div class="card p-3 sidebar">
          <h2 class="h5">Filtres</h2>
          <hr>
          <form method="GET">
            <div class="mb-3">
              <label class="form-label">Recherche</label>
              <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nom, lieu...">
            </div>
            <div class="mb-3">
              <label class="form-label">Région</label>
              <select name="region" class="form-select">
                <option value="">Toutes</option>
                @foreach($regions as $r)
                  <option value="{{ $r }}" @selected(request('region')===$r)>{{ $r }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">District</label>
              <select name="district" class="form-select">
                <option value="">Tous</option>
                @foreach($districts as $d)
                  <option value="{{ $d }}" @selected(request('district')===$d)>{{ $d }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Commune</label>
              <select name="commune" class="form-select">
                <option value="">Toutes</option>
                @foreach($communes as $c)
                  <option value="{{ $c }}" @selected(request('commune')===$c)>{{ $c }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Quantité min</label>
              <input type="number" step="0.01" name="min_quantite" value="{{ request('min_quantite') }}" class="form-control">
            </div>
            <div class="d-grid gap-2">
              <button class="btn btn-warning">Appliquer</button>
              <a href="{{ route('front.producteurs.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h1 class="h3 mb-0">Producteurs</h1>
          <a href="{{ route('frontoffice') }}" class="btn btn-sm btn-outline-secondary">Accueil</a>
        </div>

        <div class="row g-4">
          @forelse($producteurs as $p)
            <div class="col-md-6">
              <div class="card h-100">
                <div class="card-body">
                  <h5 class="card-title mb-0">{{ $p->nom }} {{ $p->prenom }}</h5>
                  <small class="text-muted">{{ $p->fokontany ? $p->fokontany.', ' : '' }}{{ $p->commune ? $p->commune.', ' : '' }}{{ $p->district ? $p->district.', ' : '' }}{{ $p->region }}</small>
                  <hr class="my-2">
                  <p class="mb-1">Adresse : {{ $p->adresse ?? '—' }}</p>
                  <p class="mb-1">Quantité dispo : <strong>{{ $p->quantite ?? '—' }}</strong></p>
                </div>
                @if($p->telephone || $p->email)
                <div class="card-footer small d-flex flex-wrap gap-3">
                  @if($p->telephone) <a href="tel:{{ $p->telephone }}" class="text-decoration-none">📞 {{ $p->telephone }}</a> @endif
                  @if($p->email) <a href="mailto:{{ $p->email }}" class="text-decoration-none">✉️ {{ $p->email }}</a> @endif
                </div>
                @endif
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="alert alert-light border">Aucun producteur trouvé.</div>
            </div>
          @endforelse
        </div>

        <div class="mt-4">
          {{ $producteurs->links() }}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
