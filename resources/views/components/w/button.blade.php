@props([
    'label' => '',
    'size' => 'btn-sm',
    'color' => 'info',
    'type' => 'submit',
    'icon' => 1,
    'wire' => null,
    'router' => null,
    'blank' => false,
])
{{-- date/text/number/ --}}
@php
    $id = \Utils::getKey();
@endphp


@if ($router == null)
    <button id="btn-{{ $id }}" class="btn {{ $size }} btn-{{ $color }} rounded-0 " role="button"
        type="submit" onclick="disable(this.id)">
        <i class="{!! \UtilsCss::icon($icon) !!}"> &nbsp;{{ $label }}</i>
        <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    </button>
@else
    <a class="btn {{ $size }} btn-{{ $color }} rounded-0 text-white " role="button"
        id="btn-{{ $id }}" href="{{ $router }}" aria-disabled="true"
        onclick="link(this.id,{{ $id }})" @if ($blank == true) target="_blank" @endif>
        <i class="{!! \UtilsCss::icon($icon) !!}">
            @if ($label != '')
                &nbsp;{{ $label }}
            @endif
        </i>
        <span id="ls-{{ $id }}" class="spinner-border spinner-border-sm d-none" role="status"
            aria-hidden="true"></span></a> &nbsp;
@endif