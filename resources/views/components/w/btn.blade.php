
@props([
    'label' => null,
    'size' => 'btn-sm',
    'color' => 'info',
    'type' => 'submit',
    'click'=> null,
    'icon' => null,
    'id' =>null,
])

@php
    $id = 1;
@endphp

    <button id="btn-{{ $id }}" :key="btn-{{ $id }}"  class="btn {{ $size }} btn-{{ $color }} rounded-0 " role="button"
         type="{{ $type }}" @if ($click != null) wire:click="{{ $click }}" @endif
            wire:loading.attr="disabled" wire:target="{{ $click }}"
         >
   
        @if ($icon != null)<i class="bi bi-{{ $icon }}">   @if ($label != null)&nbsp;{{ $label }} @endif </i> @endif
         @if ($icon == null)&nbsp{{ $label }}@endif
         <div wire:loading wire:target="{{ $click }}"> 
             <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
     </div>
        
    </button>
   
