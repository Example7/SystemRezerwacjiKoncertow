<div class="d-flex justify-content-center my-4">
    <form action="{{ request()->url() }}" method="GET" style="width: 100%; max-width: 600px;">
        <div class="input-group rounded">
            <span class="input-group-text bg-white border-2 border-gray-100">
                <i class="fa fa-search text-muted"></i>
            </span>
            <input type="text" name="search" class="form-control border-2 border-gray-100"
                placeholder="{{ $placeholder ?? 'Wyszukaj...' }}" aria-label="Search" value="{{ request('search') }}" />
            <button class="btn btn-danger" type="submit">
                Szukaj
            </button>

            @if (request()->has('search') && request('search') !== '')
                <a href="{{ request()->url() }}" class="btn btn-outline-secondary">
                    Resetuj
                </a>
            @endif
        </div>
    </form>
</div>
