@php
    $valeur ??= '';
    $titre ??= '';
    $ids ??= '';
@endphp

<div class="col-md-6 col-lg-3 col-sm-12 mb-2">
    <div class="card" style="background-color: rgb(58, 57, 57);">
        <div class="card-body">
            <div class="row d-flex align-items-center justify-content-between">
                <div class="col-8">
                    <div>
                        <h4 class="text-white" id="{{ $ids }}">{{ $valeur }}</h4>
                        <h6 class="text-warning">{{ $titre }}</h6>
                    </div>
                </div>
                <div class="col-4 text-end">
                    <i class="fas fa-users fa-2x text-secondary"></i>
                </div>
            </div>
        </div>
    </div>
</div>