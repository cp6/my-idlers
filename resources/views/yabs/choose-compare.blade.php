@section("title", "Choose YABs to compare")
@section('scripts')
    <script src="{{ asset('js/vue.min.js') }}"></script>
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Choose two YABs to compare') }}
    </x-slot>
    <div class="container" id="app">
        <div class="card shadow mt-3">
            <div class="card-body">
                <a href="{{ route('yabs.index') }}" class="btn btn-primary mb-3">YABs home</a>
                @if(count($all_yabs) >= 2)
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">YABs 1</span></div>
                                <select class="form-control" name="server1" @change="changeServer1($event)">
                                    @foreach ($all_yabs as $yabs)
                                        <option value="{{ $yabs['id'] }}">
                                            {{ $yabs->server->hostname }} ({{$yabs['output_date']}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">YABs 2</span></div>
                                <select class="form-control" name="server2" @change="changeServer2($event)">
                                    @foreach ($all_yabs as $yabs)
                                        <option value="{{ $yabs['id'] }}" {{($loop->index === 1)?'selected':''}}>
                                            {{ $yabs->server->hostname }} ({{$yabs['output_date']}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <a v-bind:href="full_url" class="btn btn-success mt-4">View comparison table</a>
                @else
                    <p class="text-danger">You need to have added at least 2 YABs to use this feature</p>
                @endif
            </div>
        </div>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>Built on Laravel
                    v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small></p>
        @endif
    </div>
    <script type="application/javascript">
        let app = new Vue({
            el: "#app",
            data: {
                "base_url": "yabs-compare/",
                "full_url": "{{route('yabs.compare', ['yabs1' => $all_yabs[0]->id, 'yabs2' => $all_yabs[1]->id])}}",
                "url_input": "",
                "server1": "{{$all_yabs[0]->id ?? ''}}",
                "server2": "{{$all_yabs[1]->id ?? ''}}",
            },
            methods: {
                changeServer1: function changeServer1(event) {
                    this.server1 = event.target.value;
                    this.full_url = this.base_url + this.server1 + '/' + this.server2;
                    this.url_input = this.full_url;
                },
                changeServer2: function changeServer2(event) {
                    this.server2 = event.target.value;
                    this.full_url = this.base_url + this.server1 + '/' + this.server2;
                    this.url_input = this.full_url;
                }
            }
        });
    </script>
</x-app-layout>
