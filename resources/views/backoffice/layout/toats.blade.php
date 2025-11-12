<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
        @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 shadow-lg rounded show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-semibold text-center">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>
</div>