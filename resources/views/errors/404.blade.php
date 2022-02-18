@section('title') {{'Error'}} {{$status}} @endsection
@section('style')
    <style>
        .page-not-found-div {
            height: 100vh;
        }

        .page-not-found-div h1 {
            font-size: 8rem;
            color: #e73974;
        }

        .page-not-found-div h3 {
            font-size: 2.5rem;
        }

        .page-not-found-div .center-div {
            width: 100%;
            padding: 0.2rem;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endsection
<x-app-layout>
    <div class="page-not-found-div">
        <div class="center-div">
            @if(isset($status))
                <h1>{{$status}}</h1>
            @else
                <h1>Error</h1>
            @endif
            @if(isset($title))
                <h3 class="mt-2">{{$title}}</h3>
            @endif
            @if(isset($message))
                <p class="mt-4">{{$message}}</p>
            @endif
            <p class="mt-4"><a href="{{route('/')}}" class="text-decoration-none">Go home</a></p>
        </div>
    </div>
</x-app-layout>
