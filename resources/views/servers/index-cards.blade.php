@section("title", "Servers")
@section('style')
    <x-modal-style></x-modal-style>
@endsection
@section('scripts')
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Servers') }}
    </x-slot>
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">Active
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(!isset($non_active_servers[0]))disabled @endif" id="profile-tab"
                        data-bs-toggle="tab" data-bs-target="#non-active" type="button" role="tab"
                        aria-controls="profile" aria-selected="false">Non active
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row mt-3">
                    @if(!empty($servers))
                        @foreach($servers as $server)
                            <div class="col-12 col-lg-4 mb-2">
                                <div class="card rounded h-100" style="overflow-y: scroll">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-lg-8">
                                                <h5 class="card-title">{{ $server->hostname }}</h5>
                                            </div>
                                            <div class="col-12 col-lg-4 text-end">
                                                <a href="{{route('servers.edit', $server->id)}}" style="color: #636363;"><i
                                                        class="fas fa-pen mx-1"></i></a>
                                                <a href="{{route('servers.show', $server->id)}}" style="color: #636363;"><i
                                                        class="fas fa-eye mx-1"></i></a>
                                                <a href="{{route('servers.show', $server->id)}}" style="color: #636363;"><i
                                                        class="fas fa-trash mx-1"></i></a>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-12 col-lg-8">
                                                <h6 class="card-subtitle mb-2 text-muted">{{ $server->location->name }}</h6>
                                            </div>
                                            <div class="col-12 col-lg-4 text-lg-end">
                                                <h6 class="card-subtitle mb-2 text-muted">{{ $server->price->currency }} {{ $server->price->price }}</h6>
                                            </div>
                                        </div>
                                        <div class="row mt-1">
                                            <div class="col-12 col-md-8">
                                                <p class="card-text">{{ $server->provider->name }}</p>
                                            </div>
                                            <div class="col-12 col-md-4 text-md-end">
                                                <p class="card-text">{{ $server->os->name }}</p>
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-6">
                                                {{$server->cpu}}
                                                <i class="fas fa-microchip mx-1" style="color: #0000008c;"></i>
                                            </div>
                                            <div class="col-6 text-end">
                                                {{$server->ram}} {{$server->ram_type}}
                                                <i class="fas fa-memory mx-1" style="color: #0000008c;"></i>
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-6">
                                                {{$server->disk}} {{$server->disk_type}}
                                                <i class="fas fa-hdd mx-1" style="color: #0000008c;"></i>
                                            </div>
                                            <div class="col-6 text-end">
                                                @if(isset($server->yabs[0]->cpu_cores))
                                                    <i class="fas fa-check mx-1" style="color: #0000008c;"></i>YABs
                                                @else
                                                    <i class="fas fa-times mx-1" style="color: #0000008c;"></i>YABs
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="non-active" role="tabpanel" aria-labelledby="non-active-tab">

            </div>
            <x-details-footer></x-details-footer>
        </div>

        <script>
            axios.defaults.headers.common = {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            };

            let app = new Vue({
                el: "#app",
                data: {
                    "status": false,
                    "modal_hostname": '',
                    "modal_id": '',
                    "delete_form_action": '',
                    showModal: false
                },
                methods: {
                    onClk(event) {
                        var hostname = event.target.id.replace('btn-', '');

                        if (hostname) {
                            axios
                                .get('/api/online/' + event.target.id.replace('btn-', ''), {headers: {'Authorization': 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content')}})
                                .then(response => (this.status = response.data.is_online))
                                .finally(() => {
                                    if (this.status) {
                                        event.target.className = "fas fa-plug text-success mx-1";
                                    } else if (!this.status) {
                                        event.target.className = "fas fa-plug text-danger mx-1";
                                    }
                                });
                        }
                    },
                    modalForm(event) {
                        this.showModal = true;
                        this.modal_hostname = event.target.id.replace('btn-', '');
                        this.modal_id = event.target.title;
                        this.delete_form_action = 'servers/' + this.modal_id;
                    }
                }
            });
        </script>
</x-app-layout>
