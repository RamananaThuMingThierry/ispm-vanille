@extends('frontoffice.app')

@php
  $type = $type ?? request('type','all');
@endphp

@section('content')
<section class="py-4">
  <div class="container">

    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h3 mb-0">Répertoire des entreprises</h1>
    </div>

    <form method="GET" class="card p-3 mb-4">
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">Type</label>
          <select name="type" class="form-select">
            <option value="all" @selected($type==='all')>Toutes</option>
            <option value="export" @selected($type==='export')>Exportatrices</option>
            <option value="import" @selected($type==='import')>Importatrices</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Pays</label>
          <select name="pays" class="form-select">
            <option value="">Tous</option>
            @foreach($paysList as $p)
              <option value="{{ $p }}" @selected(request('pays')===$p)>{{ $p }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Recherche</label>
          <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Nom, responsable, description...">
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-warning w-100">Filtrer</button>
        </div>
      </div>
    </form>

    {{-- Exportatrices --}}
    @if($type === 'all' || $type === 'export')
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h2 class="h5 mb-0">Entreprises exportatrices</h2>
        <span class="text-muted small">{{ $exportatrices->total() }} résultat(s)</span>
      </div>
      <div class="row g-4 mb-4">
        @forelse($exportatrices as $e)
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
              <div class="card-body">
                <span class="badge bg-success mb-2">Export</span>
                <h5 class="card-title mb-1">{{ $e->nom }}</h5>
                <p class="text-muted mb-2">{{ $e->pays ?? '—' }}</p>
                <p class="small mb-0">{{ \Illuminate\Support\Str::limit($e->description, 120) }}</p>
              </div>
              <div class="card-footer small d-flex gap-2">
                @if($e->telephone) <a href="tel:{{ $e->telephone }}" class="text-decoration-none">📞 {{ $e->telephone }}</a> @endif
                @if($e->email) <span>•</span> <a href="mailto:{{ $e->email }}" class="text-decoration-none">✉️ {{ $e->email }}</a> @endif
              </div>
            </div>
          </div>
        @empty
          <div class="col-12"><div class="alert alert-light border">Aucune entreprise exportatrice.</div></div>
        @endforelse
      </div>
      <div class="mb-5">
        {{ $exportatrices->links() }}
      </div>
    @endif

    {{-- Importatrices --}}
    @if($type === 'all' || $type === 'import')
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h2 class="h5 mb-0">Entreprises importatrices</h2>
        <span class="text-muted small">{{ $importatrices->total() }} résultat(s)</span>
      </div>
      <div class="row g-4 mb-4">
        @forelse($importatrices as $i)
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
              <div class="card-body">
                <span class="badge bg-primary mb-2">Import</span>
                <h5 class="card-title mb-1">{{ $i->nom }}</h5>
                <p class="text-muted mb-2">{{ $i->pays ?? '—' }}</p>
                <p class="small mb-0">{{ \Illuminate\Support\Str::limit($i->description, 120) }}</p>
              </div>
              <div class="card-footer small d-flex gap-2">
                @if($i->telephone) <a href="tel:{{ $i->telephone }}" class="text-decoration-none">📞 {{ $i->telephone }}</a> @endif
                @if($i->email) <span>•</span> <a href="mailto:{{ $i->email }}" class="text-decoration-none">✉️ {{ $i->email }}</a> @endif
              </div>
            </div>
          </div>
        @empty
          <div class="col-12"><div class="alert alert-light border">Aucune entreprise importatrice.</div></div>
        @endforelse
      </div>
      <div>
        {{ $importatrices->links() }}
      </div>
    @endif

  </div>
</section>
@endsection
