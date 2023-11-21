{{-- <x-layout title="Editar Série: '{{ $series->nome }}'"> --}}
<x-layout title="Editar Série: '{!! $series->nome !!}'">
    <x-series.form :action="route('series.update', $series->id)" :nome="$series->nome" :update="true" />

    {{-- <form action="{{ route('series.update', $series->id) }}" method="post">
        @csrf
        @method('put')

        <div class="row mb-3">
            <div class="col-8">
                <label for="nome" class="form-label">Nome:</label>
                <input autofocus type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}">
            </div>

            <div class="col-2">
                <label for="seasonsQty" class="form-label">Nº Temporadas:</label>
                <input type="text" id="seasonsQty" name="seasonsQty" class="form-control" value="{{ old('seasonsQty') }}">
            </div>

            <div class="col-2">
                <label for="episodesPerSeason" class="form-label">Eps / Temporada:</label>
                <input type="text" id="episodesPerSeason" name="episodesPerSeason" class="form-control" value="{{ old('episodesPerSeason') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form> --}}
</x-layout>