<x-layout>
    <div class="container my-5">
        <h2>Edytuj swoją ocenę</h2>

        <form action="{{ route('ratings.update', $rating) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Ocena (1-5)</label>
                <input type="number" name="value" min="1" max="5" value="{{ $rating->value }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label>Komentarz</label>
                <textarea name="comment" class="form-control">{{ $rating->comment }}</textarea>
            </div>

            <button class="btn btn-primary">Aktualizuj</button>

        </form>

        <form action="{{ route('ratings.destroy', $rating) }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Usuń ocenę</button>
        </form>
    </div>
</x-layout>
