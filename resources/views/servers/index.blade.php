@section('title') {{'Servers'}} @endsection
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
                <x-card class="shadow mt-3">
                    <a href="{{ route('servers.create') }}" class="btn btn-primary mb-3">Add server</a>
                    <a href="{{ route('servers-compare-choose') }}" class="btn btn-primary mb-3 ms-2">Compare
                        servers</a>
                    <a href="{{ route('yabs.create') }}" class="btn btn-primary mb-3 ms-2">Add a YABs</a>
                    <x-success-alert></x-success-alert>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr class="bg-gray-100">
                                <th>Name</th>
                                <th class="text-center"><i class="fas fa-box" title="Virt"></i></th>
                                <th class="text-center">OS</th>
                                <th class="text-center"><i class="fas fa-microchip" title="CPU"></i></th>
                                <th class="text-center"><i class="fas fa-memory" title="ram"></i></th>
                                <th class="text-center"><i class="fas fa-compact-disc" title="disk"></i></th>
                                <th>Location</th>
                                <th>Provider</th>
                                <th>Price</th>
                                <th>Due in</th>
                                <th class="text-center">Had since</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($servers))
                                @foreach($servers as $server)
                                    <tr>
                                        <td>{{ $server->hostname }}</td>
                                        <td class="text-center">
                                            {{ App\Models\Server::serviceServerType($server->server_type) }}
                                        </td>
                                        <td class="text-center">{!!App\Models\Server::osIntToIcon($server->os_id, $server->os_name)!!}</td>
                                        <td class="text-center">{{$server->cpu}}</td>
                                        <td class="text-center">
                                            @if(isset($server->ram))
                                                {{ $server->ram }}<small>{{$server->ram_type}}</small>
                                            @else
                                                {{$server->ram_as_mb}}<small>MB</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($server->disk))
                                                {{ $server->disk }}<small>{{$server->disk_type}}</small>
                                            @else
                                                {{$server->disk}}<small>GB</small>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ $server->location }}</td>
                                        <td class="text-nowrap">{{ $server->provider_name }}</td>
                                        <td class="text-nowrap">{{ $server->price }} {{$server->currency}} {{\App\Process::paymentTermIntToString($server->term)}}</td>
                                        <td class="text-nowrap">
                                            {{now()->diffInDays(Carbon\Carbon::parse($server->next_due_date))}}
                                            <small>days</small></td>
                                        <td class="text-nowrap"> {{ $server->owned_since }}</td>
                                        <td class="text-nowrap">
                                            <form action="{{ route('servers.destroy', $server->id) }}" method="POST">
                                                <a href="{{ route('servers.show', $server->id) }}"
                                                   class="text-body mx-1">
                                                    <i class="fas fa-eye" title="view"></i>
                                                </a>
                                                <a href="{{ route('servers.edit', $server->id) }}"
                                                   class="text-body mx-1">
                                                    <i class="fas fa-pen" title="edit"></i>
                                                </a>

                                                <i class="fas fa-plug mx-1" id="btn-{{$server->hostname}}"
                                                   title="check if up"
                                                   @click="onClk">
                                                </i>
                                                <i class="fas fa-trash text-danger ms-3" @click="modalForm"
                                                   id="btn-{{$server->hostname}}" title="{{$server->id}}"></i>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-4 py-2 border text-red-500" colspan="3">No servers found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
            <div class="tab-pane fade" id="non-active" role="tabpanel" aria-labelledby="non-active-tab">
                <x-card class="shadow mt-3">
                    <a href="{{ route('servers.create') }}" class="btn btn-primary mb-3">Add server</a>
                    <a href="{{ route('servers-compare-choose') }}" class="btn btn-primary mb-3 ms-2">Compare
                        servers</a>
                    <x-success-alert></x-success-alert>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr class="bg-gray-100">
                                <th>Name</th>
                                <th class="text-center"><i class="fas fa-box" title="Virt"></i></th>
                                <th class="text-center">OS</th>
                                <th class="text-center"><i class="fas fa-microchip" title="CPU"></i></th>
                                <th class="text-center"><i class="fas fa-memory" title="ram"></i></th>
                                <th class="text-center"><i class="fas fa-compact-disc" title="disk"></i></th>
                                <th>Location</th>
                                <th>Provider</th>
                                <th>Price</th>
                                <th class="text-center">Had since</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($non_active_servers))
                                @foreach($non_active_servers as $server)
                                    <tr>
                                        <td>{{ $server->hostname }}</td>
                                        <td class="text-center">
                                            {{ App\Models\Server::serviceServerType($server->server_type) }}
                                        </td>
                                        <td class="text-center">{!!App\Models\Server::osIntToIcon($server->os_id, $server->os_name)!!}</td>
                                        <td class="text-center">{{$server->cpu}}</td>
                                        <td class="text-center">
                                            @if($server->ram_as_mb > 1024)
                                                {{ number_format(($server->ram_as_mb / 1024),0) }}<small>GB</small>
                                            @else
                                                {{$server->ram_as_mb}}<small>MB</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($server->disk > 1000)
                                                {{ number_format(($server->disk / 1024),1) }}<small>TB</small>
                                            @else
                                                {{$server->disk}}<small>GB</small>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ $server->location }}</td>
                                        <td class="text-nowrap">{{ $server->provider_name }}</td>
                                        <td class="text-nowrap">{{ $server->price }} {{$server->currency}} {{\App\Process::paymentTermIntToString($server->term)}}</td>
                                        <td class="text-center"> {{ $server->owned_since }}</td>
                                        <td class="text-nowrap">
                                            <form action="{{ route('servers.destroy', $server->id) }}" method="POST">
                                                <a href="{{ route('servers.show', $server->id) }}"
                                                   class="text-body mx-1">
                                                    <i class="fas fa-eye" title="view"></i>
                                                </a>
                                                <a href="{{ route('servers.edit', $server->id) }}"
                                                   class="text-body mx-1">
                                                    <i class="fas fa-pen" title="edit"></i>
                                                </a>

                                                <i class="fas fa-plug mx-1" id="btn-{{$server->hostname}}"
                                                   title="check if up"
                                                   @click="onClk">
                                                </i>
                                                <i class="fas fa-trash text-danger ms-3" @click="modalForm"
                                                   id="btn-{{$server->hostname}}" title="{{$server->id}}"></i>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-4 py-2 border text-red-500" colspan="3">No non-active servers found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
            @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
                <p class="text-muted mt-4 text-end"><small>Built on Laravel
                        v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small></p>
            @endif
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
