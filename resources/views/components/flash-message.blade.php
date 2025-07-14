@if (session()->has('success'))
    <div id="success-alert"
        class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 px-5 shadow"
        role="alert" style="z-index: 1050; min-width: 300px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Zamknij"></button>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 1000);
            }
        }, 4000);
    </script>
@endif
