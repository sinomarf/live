@props([
    'label' => '',
     'name' => '',
    'col' => '2',
    'type' => 'text',
      'error' => null,
       'ro' => false,
    'maxlength' => null,
    'color' => '#d8d8d8',
    'blur' => false,
    'disabled' => false,
    'class' => 'form-control',
  
])
   <div class="col-md-{{$col}}">
    <label class="form-label">{{$label}}: </label>

    <input type="{{$type}}" id="{{$name}}"
      @if ($disabled == true) disabled @endif
      @if ($blur == true) wire:model.blur="{{$name}}" @else wire:model="{{$name}}" @endif
       autocomplete="nope"
            @if ($ro == true) readOnly style="background-color: {{ $color }};" @endif
         step="any" @if ($maxlength != null) maxlength="{{$maxlength}}" @endif
        class="@error($name) form-control border border-danger @else {{ $class }} @enderror"  >
        @error($name) <em class="text-danger">{{ $message }}</em>@enderror
   </div>