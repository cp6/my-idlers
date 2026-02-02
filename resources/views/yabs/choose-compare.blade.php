@section("title", "Choose YABS to compare")
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Compare YABS</h2>
            <div class="page-actions">
                <a href="{{ route('yabs.index') }}" class="btn btn-outline-secondary">Back to YABS</a>
            </div>
        </div>

        <div class="card content-card">
            <div class="card-header card-section-header">
                <h5 class="card-section-title mb-0">Select YABS to Compare</h5>
            </div>
            <div class="card-body">
                @if(count($all_yabs) >= 2)
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">YABS 1</label>
                            <select class="form-select" name="server1" @change="changeServer1($event)">
                                @foreach ($all_yabs as $yabs)
                                    <option value="{{ $yabs['id'] }}">
                                        {{ $yabs->server->hostname }} ({{ $yabs['output_date'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label class="form-label">YABS 2</label>
                            <select class="form-select" name="server2" @change="changeServer2($event)">
                                @foreach ($all_yabs as $yabs)
                                    <option value="{{ $yabs['id'] }}" {{ $loop->index === 1 ? 'selected' : '' }}>
                                        {{ $yabs->server->hostname }} ({{ $yabs['output_date'] }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a v-bind:href="full_url" class="btn btn-primary">View Comparison</a>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        You need to have added at least 2 YABS to use this feature.
                    </div>
                @endif
            </div>
        </div>

        <x-details-footer></x-details-footer>
    </div>

    <script type="application/javascript">
        window.addEventListener('load', function() {
            let app = new Vue({
                el: "#app",
                data: {
                    "base_url": "{{ url('yabs-compare') }}/",
                    "full_url": "{{ route('yabs.compare', ['yabs1' => $all_yabs[0]->id, 'yabs2' => $all_yabs[1]->id]) }}",
                    "url_input": "",
                    "server1": "{{ $all_yabs[0]->id ?? '' }}",
                    "server2": "{{ $all_yabs[1]->id ?? '' }}",
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
        });
    </script>
</x-app-layout>
