@section('title') {{'Choose servers'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Choose two servers to compare') }}
    </x-slot>
    <div class="container" id="app">
        <div class="card shadow mt-3">
            <div class="card-body">
                <a href="{{ route('servers.index') }}" class="btn btn-primary mb-3">Servers home</a>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Server1</span></div>
                            <select class="form-control" name="server1" @change="changeServer1($event)">
                                @foreach ($all_servers as $server)
                                    <option value="{{ $server['id'] }}">
                                        {{ $server['hostname'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Server2</span></div>
                            <select class="form-control" name="server2" @change="changeServer2($event)">
                                @foreach ($all_servers as $server)
                                    <option value="{{ $server['id'] }}">
                                        {{ $server['hostname'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!--
                <div class="input-group mt-4">
                    <div class="input-group-prepend"><span class="input-group-text">URL</span></div>
                    <input type="text" class="form-control" id="url" v-model="url_input" disabled>
                </div>
-->
                <a v-bind:href="full_url" class="btn btn-success mt-4">View comparison table</a>
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
                "base_url": "servers-compare/",
                "full_url": "",
                "url_input": "",
                "server1": "",
                "server2": "",
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
