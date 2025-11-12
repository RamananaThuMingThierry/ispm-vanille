@extends('backoffice.admin')

@section('titre', __('title.dashboard'))

@section('content')
    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
        </div>
    </div>

    <div class="row">
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

    <div class="row my-2">
        <div class="col-12">
            <div class="card shadow-none" style="height: 500px;">
                <canvas id="reservationsChart" height="500"></canvas>
            </div>
        </div>
    </div>

    <div class="row mb-2">
       <div class="col-12">
            <div class="card shadow-sm p-0">
                <div class="card-body">
                    <h5 class="mb-3">{{ __('dashboard.dernieres_entrees_marches') ?? 'Dernières entrées de marché' }}</h5>
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
                                        <td>{{ $m->produit }}</td>
                                        <td>
                                            {{ number_format($m->prix, 2, ',', ' ') }}
                                        </td>
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
    const ctx = document.getElementById('reservationsChart').getContext('2d');
    const reservationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $labels !!},
            datasets: [{
                label: "{{ __('dashboard.marches_par_mois') ?? 'Entrées marchés par mois' }}",
                data: {!! $data !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush
