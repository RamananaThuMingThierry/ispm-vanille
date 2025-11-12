@extends('frontoffice.app')

@section('content')
<section class="py-4">
  <div class="container">

    <div class="d-flex align-items-center justify-content-between mb-3">
      <h1 class="h3 mb-0">Actualités</h1>
      <a href="{{ route('frontoffice') }}" class="btn btn-sm btn-outline-secondary">Accueil</a>
    </div>

    <form method="GET" class="card p-3 mb-4">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Recherche</label>
          <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Mot-clé...">
        </div>
        <div class="col-md-4">
          <label class="form-label">À la une</label>
          <select name="ala_une" class="form-select">
            <option value="">Toutes</option>
            <option value="1" @selected(request('ala_une')==='1')>Oui</option>
            <option value="0" @selected(request('ala_une')==='0')>Non</option>
          </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-warning w-100">Filtrer</button>
        </div>
      </div>
    </form>

    <div class="row g-4">
      @forelse($actus as $a)
        <div class="col-md-6 col-lg-4">
          <article class="card h-100">
            @if($a->image)
              <img src="{{ asset($a->image) }}" class="card-img-top" alt="{{ $a->titre }}" style="height:180px; object-fit:cover;">
            @endif
            <div class="card-body">
              <h5 class="card-title">{{ $a->titre }}</h5>
              <p class="text-muted small mb-2">{{ $a->created_at->translatedFormat('d M Y') }}</p>
              <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($a->contenu), 120) }}</p>
              <a href="{{ route('front.actualites.show', $a->id) }}" class="stretched-link">Lire</a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12"><div class="alert alert-light border">Aucune actualité.</div></div>
      @endforelse
    </div>

    <div class="mt-4">
      {{ $actus->links() }}
    </div>
  </div>
</section>
@endsection
