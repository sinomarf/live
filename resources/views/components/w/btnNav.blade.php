@props([
    'label' => null,
    'size' => 'btn-sm',
    'color' => 'info',
    'router' => null,
    'blank' => false,
    'icon' => null,
])

@php
    $id = 1;
@endphp

    <a wire:navigate class="btn {{ $size }} btn-{{ $color }} rounded-0 text-white " role="button"
        id="btn-{{ $id }}" href="{{ $router }}" 
                @if ($blank == true) target="_blank" @endif>
         @if ($icon != null)<i class="bi bi-{{ $icon }}">   @if ($label != null)&nbsp;{{ $label }} @endif </i> @endif
        @if ($icon == null)&nbsp;{{ $label }}@endif
    </a>