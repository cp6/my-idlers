@if ($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        <p class="my-1">{{ $message }}</p>
    </div>
@endif
