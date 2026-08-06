@php
    $alertTypes = [
        'success' => ['class' => 'bg-success text-white', 'auto_hide' => 'true', 'delay' => 7000, 'title' => 'Success'],
        'error' => ['class' => 'bg-danger text-white', 'auto_hide' => 'false', 'delay' => 0, 'title' => 'Error'],
        'warning' => ['class' => 'bg-warning text-dark', 'auto_hide' => 'false', 'delay' => 0, 'title' => 'Warning'],
        'info' => ['class' => 'bg-info text-dark', 'auto_hide' => 'false', 'delay' => 0, 'title' => 'Notice'],
    ];
@endphp

<!-- Toast Container (Fixed Popup Position) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">

    {{-- Session Flash Messages --}}
    @foreach ($alertTypes as $key => $config)
        @if (session()->has($key))
            <div class="toast align-items-center {{ $config['class'] }} border-0 shadow-lg" role="alert"
                aria-live="assertive" aria-atomic="true" data-bs-autohide="{{ $config['auto_hide'] }}"
                data-bs-delay="{{ $config['delay'] }}">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>{{ $config['title'] }}:</strong> {{ session($key) }}
                    </div>
                    <button type="button"
                        class="btn-close {{ str_contains($config['class'], 'text-white') ? 'btn-close-white' : '' }} me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    @endforeach

    {{-- Validation Errors Summary --}}
    @if ($errors->any())
        <div class="toast align-items-center bg-danger text-white border-0 shadow-lg" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 mt-2 align-self-start"
                    data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

</div>
