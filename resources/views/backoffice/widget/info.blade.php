@php
    $label ??= '';
    $valeur ??= '';
    $ids ??= '';

    $output = match (true) {
        $label === 'Numéro carte' && intval($valeur) === 1 => '<p class="mb-0 text-dark">1</p>',
        $valeur === 0 || $valeur === '0' => '<p class="mb-0 text-dark badge bg-danger w-50 py-3">En attente</p>',
        $valeur === 1 || $valeur === '1' => '<p class="mb-0 badge bg-success w-50 py-3">Active</p>',
        $valeur === 'Utilisateurs' => '<p class="mb-0 badge bg-success w-50 py-3">Utilisateurs</p>',
        $valeur === 'Administrateurs' => '<p class="mb-0 badge bg-info w-50 py-3">Administrateurs</p>',
        $label === 'Facebook' => '<p class="mb-0 text-dark" id="' . $ids . '"><a href="https://www.facebook.com/search/top/?q=' . $valeur . '" class="text-decoration-none" target="_blank">' . $valeur . '</a></p>',
        default => '<p class="mb-0 text-dark" id="' . $ids . '">' . $valeur . '</p>'
    };
@endphp

<div class="row">
  <div class="col-sm-5">
    <p class="text-dark fw-bold mb-0">{{ $label }}</p>
  </div>
  <div class="col-sm-7">{!! $output !!}</div>
</div>
