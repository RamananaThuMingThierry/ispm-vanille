@php
  $titre ??= '';
  $ids ??= '';
@endphp

<div class="row pt-2">
  <div class="col-12 d-flex align-items-center justify-content-between">
    <h2 class="text-primary">@yield('titre')</h2>
    <button class="btn btn-sm btn-success shadow-sm d-flex align-items-center" id="{{ $ids }}">
      <i class="fas fa-plus p-1 text-white-50"></i>
      <span class="d-none d-sm-inline">&nbsp;{{ $titre }}</span>
    </button>
  </div>
</div>