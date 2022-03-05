<main class="form-signin">
<div class="card">
    <div class="card-body shadow">
        @if(isset($logo))
            <div>
                {{ $logo }}
            </div>
        @endif
        {{ $slot }}
    </div>
</div>
</main>
