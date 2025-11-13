@extends('backoffice.admin')

@section('titre', __('title.dashboard'))

@section('content')
    <div class="row pt-2 mb-3">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
        </div>
    </div>

    {{-- Filtres année / mois --}}
    <form method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-md-4">
            <label for="year" class="form-label">{{ __('dashboard.year') ?? 'Année' }}</label>
            <select name="year" id="year" class="form-select">
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ (int)$selectedYear === (int)$year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="month" class="form-label">{{ __('dashboard.month') ?? 'Mois' }}</label>
            <select name="month" id="month" class="form-select">
                <option value="">{{ __('dashboard.all_months') ?? 'Tous les mois' }}</option>
                @foreach($months as $num => $label)
                    <option value="{{ $num }}" {{ (int)$selectedMonth === (int)$num ? 'selected' : '' }}>
                        {{ ucfirst($label) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-filter"></i> {{ __('form.filter') ?? 'Filtrer' }}
            </button>
            @if(request()->hasAny(['year','month']))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary ms-1">
                    {{ __('form.reset') ?? 'Réinitialiser' }}
                </a>
            @endif
        </div>
    </form>

    {{-- Cartes de synthèse --}}
    <div class="row g-3 mb-3">
        <div class="col">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-tractor me-1"></i>&nbsp;{{ __('dashboard.producteurs') ?? 'Producteurs' }}
                    </h5>
                    <p class="card-text fs-4">{{ $producteursCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-building me-1"></i>&nbsp;{{ __('dashboard.exportatrices') ?? "Entreprises exportatrices" }}
                    </h5>
                    <p class="card-text fs-4">{{ $exportatricesCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-warehouse me-1"></i>&nbsp;{{ __('dashboard.importatrices') ?? "Entreprises importatrices" }}
                    </h5>
                    <p class="card-text fs-4">{{ $importatricesCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-store me-1"></i>&nbsp;{{ __('dashboard.marches') ?? "Marchés" }}
                    </h5>
                    <p class="card-text fs-4">{{ $marchesCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-secondary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-newspaper me-1"></i>&nbsp;{{ __('dashboard.actualites') ?? "Actualités" }}
                    </h5>
                    <p class="card-text fs-4">{{ $actualitesCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="row mb-3">
        <div class="col-md-8 mb-3 mb-md-0">
            <div class="card shadow-sm" style="height: 450px;">
                <div class="card-header py-2">
                    <strong>
                        @if($chartMode === 'months')
                            {{ __('dashboard.marches_par_mois') ?? 'Entrées marchés par mois' }}
                            ({{ $selectedYear }})
                        @else
                            {{ __('dashboard.marches_par_jour') ?? 'Entrées marchés par jour' }}
                            – {{ ucfirst($months[$selectedMonth]) }} {{ $selectedYear }}
                        @endif
                    </strong>
                </div>
                <div class="card-body p-2">
                    <canvas id="marchesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm" style="height: 450px;">
                <div class="card-header py-2">
                    <strong>{{ __('dashboard.offres_demandes') ?? 'Offres vs Demandes' }}</strong>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center p-4">
                    <canvas id="annoncesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Dernières entrées de marché --}}
    <div class="row mb-2">
       <div class="col-12">
            <div class="card shadow-sm p-0">
                <div class="card-body">
                    <h5 class="mb-3">
                        {{ __('dashboard.dernieres_entrees_marches') ?? 'Dernières entrées de marché' }}
                        ({{ $selectedYear }})
                        @if($selectedMonth)
                            – {{ ucfirst($months[$selectedMonth]) }}
                        @endif
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-sm mt-2">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('dashboard.date') ?? 'Date' }}</th>
                                    <th>{{ __('dashboard.produit') ?? 'Produit' }}</th>
                                    <th>{{ __('dashboard.prix') ?? 'Prix' }}</th>
                                    <th>{{ __('dashboard.disponibilite') ?? 'Disponibilité' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lastMarches as $m)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($m->date)->locale('fr')->translatedFormat('d F Y') }}</td>
                                        <td>{{ optional($m->produit)->nom ?? '—' }}</td>
                                        <td>{{ number_format($m->prix, 2, ',', ' ') }}</td>
                                        <td>{{ $m->disponibilite ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucune donnée disponible.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
       </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset(config('public_path.public_path').'vendor/chart/js/chart.min.js') }}"></script>
<script>
    // Données envoyées par le contrôleur
    const marchesLabels   = @json($labels);
    const marchesData     = @json($data);
    const chartMode       = @json($chartMode);
    const annoncesLabels  = @json($annonceLabels);
    const annoncesData    = @json($annonceData);


    // === Graphique barres : marchés (par mois OU par jour) ===
    const marchesCanvas = document.getElementById('marchesChart');
    if (marchesCanvas) {
        const marchesCtx = marchesCanvas.getContext('2d');

        const marchesChart = new Chart(marchesCtx, {
            type: 'bar',
            data: {
                labels: marchesLabels,
                datasets: [{
                    label: chartMode === 'months'
                        ? "{{ __('dashboard.marches_par_mois') ?? 'Entrées marchés par mois' }}"
                        : "{{ __('dashboard.marches_par_jour') ?? 'Entrées marchés par jour' }}",
                    data: marchesData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1,
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // s'adapte à la hauteur de la card
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    // === Graphique en cercle : Offres vs Demandes ===
    const annoncesCanvas = document.getElementById('annoncesChart');
    if (annoncesCanvas) {
        const annoncesCtx = annoncesCanvas.getContext('2d');

        const annoncesChart = new Chart(annoncesCtx, {
            type: 'doughnut',
            data: {
                labels: annoncesLabels,
                datasets: [{
                    data: annoncesData,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',   // Offres
                        'rgba(255, 99, 132, 0.7)',   // Demandes
                    ],
                    borderColor: [
                        'rgb(75, 192, 192)',
                        'rgb(255, 99, 132)',
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }
</script>
@endpush
