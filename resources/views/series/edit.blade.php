<x-layout title="Editar Série: '{{ $series->nome }}'">
    <x-series.form :action="route('series.update', $series->id)" :nome="$series->nome" />

    {{-- <form action="{{ route('series.update') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form> --}}
</x-layout>