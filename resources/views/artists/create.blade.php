<x-layout>
    <div class="container my-5">
        <h1 class="mb-4">Dodaj artystę</h1>

        <form action="{{ route('artists.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nazwa</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Gatunek</label>
                <input type="text" name="genre" class="form-control @error('genre') is-invalid @enderror"
                    value="{{ old('genre') }}">
                @error('genre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Zapisz</button>
            <a href="{{ route('artists.index') }}" class="btn btn-secondary">Anuluj</a>
        </form>
    </div>
</x-layout>
