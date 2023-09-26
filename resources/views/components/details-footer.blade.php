@if(Session::get('timer_version_footer', 0) === 1)
    <p class="text-muted mt-4 text-end"><small>Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP
            v{{ PHP_VERSION }})</small></p>
@endif
