<div class="card {{ $class ?? '' }}">
    @isset($header)
        <div class="card-header">
            {!! $header !!}
        </div>
    @endisset
    @isset($body)
        <div class="card-body pb-0">
            {!! $body !!}
            {{ $slot }}
        </div>
    @endisset
    @isset($footer)
        <div class="card-footer">
            {!! $footer !!}
        </div>
    @endisset
</div>
