<x-layout>
    <div class="container my-5">
        <h1 class="mb-4">Edytuj artystę</h1>

        <form action="{{ route('artists.update', $artist) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nazwa</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $artist->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Gatunek</label>
                <input type="text" name="genre" class="form-control @error('genre') is-invalid @enderror"
                    value="{{ old('genre', $artist->genre) }}">
                @error('genre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
            <a href="{{ route('artists.index') }}" class="btn btn-secondary">Anuluj</a>
        </form>
    </div>
</x-layout>
