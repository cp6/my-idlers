@section("title", "Insert YABS")
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a YABs') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">YABs</h4>
            <x-back-button>
                <x-slot name="href">{{ route('yabs.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('yabs.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-4 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Server</span></div>
                            <select class="form-control" name="server_id">
                                @foreach ($Servers as $s)
                                    <option value="{{ $s['id'] }}">
                                        {{ $s['hostname'] }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                </div>
                <div class="row">
                    <p>YABs output: <code>curl -sL yabs.sh | bash</code> <b>or</b> <code>curl -sL yabs.sh | bash -s --
                            -r</code> <b>only</b></p>
                    <div class="col-12">
                        <textarea class="form-control" name="yabs" rows="18"
                                  placeholder="First line must be: # ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## ## #"
                                  required></textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Insert YABs</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
