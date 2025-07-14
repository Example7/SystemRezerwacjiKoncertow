<x-layout>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Edytuj koncert</h2>

                <form action="/concerts/{{ $concert->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Tytuł koncertu</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ $concert->title }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ $concert->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Tagi (oddzielone przecinkami)</label>
                        <input type="text" name="tags" class="form-control @error('tags') is-invalid @enderror"
                            value="{{ $concert->tags }}">
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Data koncertu</label>
                        <input type="datetime-local" name="date"
                            class="form-control @error('date') is-invalid @enderror"
                            value="{{ $concert->concert_date }}">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Cena biletu (zł)</label>
                        <input type="number" step="0.01" name="price"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $concert->tickets->first()->price ?? '') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="available_tickets" class="form-label">Dostępne bilety</label>
                        <input type="number" name="available_tickets"
                            class="form-control @error('available_tickets') is-invalid @enderror"
                            value="{{ $concert->available_tickets }}">
                        @error('available_tickets')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location_id" class="form-label">Lokalizacja</label>
                        <select name="location_id" class="form-select @error('location_id') is-invalid @enderror">
                            <option value="">-- Wybierz lokalizację --</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ optional($concert->location)->id == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }} – {{ $location->address }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Artyści</label>
                        <div>
                            @foreach ($artists as $artist)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="artists[]"
                                        value="{{ $artist->id }}" id="artist-{{ $artist->id }}"
                                        {{ collect(old('artists'))->contains($artist->id) || $concert->artists->contains($artist->id) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="artist-{{ $artist->id }}">
                                        {{ $artist->name }} ({{ $artist->genre ?? 'brak' }})
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('artists')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $concert->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label">Strona internetowa</label>
                        <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                            value="{{ old('website', $concert->website) }}">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Wróć</a>
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
