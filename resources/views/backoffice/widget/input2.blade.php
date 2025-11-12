@php
    $label ??= '';
    $type ??= 'text';
    $name ??= '';
    $value ??= '';
    $error ??= '';
@endphp

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-bold">{{  $label }}</label>
    <input type="{{ $type }}" class="form-control" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}">
    <span class="text-danger error-message" id="{{ $error }}"></span>
</div>
