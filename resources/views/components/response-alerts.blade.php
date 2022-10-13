@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
        <p class="my-1">{{ $message }}</p>
    </div>
@elseif($message = Session::get('error'))
    <div class="alert alert-danger" role="alert">
        <p class="my-1">{{ $message }}</p>
    </div>
@endif
