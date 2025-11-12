<?php
    $url = $url ?? '#';
    $icon = $icon ?? '';
    $name = $name ?? '';
    $faIcons ??= true;
?>

<a class="nav-link" href="{{ $url }}">
    @if($faIcons)
        <div class="sb-nav-link-icon"><i class="fas {{ $icon }}"></i></div>
    @else
        <div class="sb-nav-link-icon"><i class="bi {{ $icon }}"></i></div>
    @endif
        {{ __($name) }}
    @if(isset($ids) && !empty($ids))
        <div class="sb-sidenav-collapse-arrow"><span class="badge bg-danger" id="{{ $ids }}">0</span></div>
    @else
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-right"></i></div>
    @endif
    
</a>