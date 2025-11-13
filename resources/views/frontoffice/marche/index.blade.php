@extends('frontoffice.app')

@push('style')
    <style>
        body {
            background-image: url('/images/V5.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }
        .card-hover {
            transition: transform .25s, box-shadow .25s;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(4px);
        }
    </style>
@endpush


@section('content')
    <section class="section-padding section-marche-bg">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between p-4">
                    <h1 class="h3 mb-0">Marchés</h1>
                    <a href="{{ route('frontoffice') }}" class="btn btn-sm btn-outline-secondary">Accueil</a>
                </div>

                {{-- FILTRES --}}
                <form method="GET" class="card mb-4 p-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                placeholder="Vanille, ...">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Produit</label>
                            <select name="produit" class="form-select">
                                <option value="">Tous</option>
                                @foreach ($produits as $id => $nom)
                                    <option value="{{ $id }}" @selected((string) request('produit') === (string) $id)>
                                        {{ $nom }}
                                    </option>
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
                            <label class="form-label">Prix min (Ar)</label>
                            <input type="number" step="0.01" name="min_prix" value="{{ request('min_prix') }}"
                                class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Prix max (Ar)</label>
                            <input type="number" step="0.01" name="max_prix" value="{{ request('max_prix') }}"
                                class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Disponibilité min</label>
                            <input type="number" name="disponibilite_min" value="{{ request('disponibilite_min') }}"
                                class="form-control">
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button class="btn btn-warning me-2">Filtrer</button>
                            <a href="{{ route('front.marche.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                        </div>
                    </div>
                </form>

                {{-- LISTE DES MARCHÉS --}}
                <div class="row g-4">
                    @forelse($marches as $m)
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-hover h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">
                                            {{ optional($m->produit)->nom ?? 'Produit inconnu' }}
                                        </h5>
                                        <span class="badge bg-light text-dark">
                                            @if ($m->date)
                                                {{ $m->date->locale('fr')->translatedFormat('d M Y') }}
                                            @endif
                                        </span>
                                    </div>

                                    @if ($m->marche)
                                        <p class="mb-1 small text-muted">
                                            Marché : <strong>{{ $m->marche }}</strong>
                                        </p>
                                    @endif

                                    <p class="mb-1 text-muted">
                                        Prix :
                                        <strong>{{ number_format($m->prix, 2, ',', ' ') }}
                                            {{ $m->monnaie ?? 'MGA' }}</strong>
                                    </p>

                                    <p class="mb-0 text-muted">
                                        Disponibilité :
                                        {{ $m->disponibilite !== null ? $m->disponibilite : '—' }}
                                    </p>
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
                    {{ $marches->withQueryString()->links() }}
                </div>
            </div>
    </section>
@endsection
