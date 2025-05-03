@props([
    'url' => '',
])


@section('footer')
    <x-w.btnNav label="Voltar" icon="bi bi-skip-backward" router="{{ route($url ) }}" size="">
    </x-w.btnNav>
    &nbsp;&nbsp;
    <x-w.btn label="Gravar" icon="bi bi-save" size="">
    </x-w.btn>
@endsection