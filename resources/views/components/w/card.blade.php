
@props([
    'title' => '',
    'enableFooter' => true,
    'enableHeader' => true,
    'displayMsg'=> true,
    'urlNew' => '',
])

@if ($enableHeader == "true")
    <div class="row">
        <div class="col-md-12  col-xl-12">
                 <h3 class="text-dark text-start">{{ $title }}</h3>

             <hr class="border border-info border-3 opacity-75">
        </div>
    </div>
@endif

     @if ($displayMsg == "true")
         
<div class="my-2">
     {!! \Utils::doMessage($errors) !!}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    {{ session('error') }}
                </div>
            @endif
        
    @endif
{{ $slot }}
</div>
@if ($enableFooter == "true")
    <div class="row">
      <hr class="solid">
        <div class="d-flex justify-content-center">
            <div class="btn-group" role="group">
            
                @yield('footer')
            </div>
        </div>
    </div>
@endif
{{-- 
   
         <h3 class="{{ $text_h2 }}">{{ $label }}</h3>
   @endif
<div class="card text-left border-0 ">
    @if ($enableHeader == 'true')
        <div class="card-header {{ $text_bg }}">
            <h3 class="{{ $text_h2 }}">{{ $label }}</h3>
        </div>
    @endif
    <div class="card-body">

        @if ($displayError == 'true')
            {!! \App\Helper\Utils::doMessage($errors) !!}
        @endif

            {{ $slot }}
    </div>
    @if ($enableFooter == 'true')
        <div class="card-footer text-muted">
            <x-group-button>

                @yield('footer')

            </x-group-button>
          </div>
    @endif
</div>
 --}}
