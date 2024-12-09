@section('title', 'Servers')
<x-app-layout>
    <x-slot name="header">
        {{ __('Servers') }}
    </x-slot>
    <div class="container" id="app">
        <x-response-alerts></x-response-alerts>
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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="servers-table">
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
                                        <td class="text-center">{{ App\Models\Server::serviceServerType($server->server_type) }}</td>
                                        <td class="text-center">@if(isset($server->os)){!!App\Models\Server::osIntToIcon($server->os->id, $server->os->name)!!}@endif</td>
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
                                        <td class="text-nowrap">{{ $server->location->name }}</td>
                                        <td class="text-nowrap">{{ $server->provider->name }}</td>
                                        <td class="text-nowrap">{{ $server->price->price }} {{$server->price->currency}} {{\App\Process::paymentTermIntToString($server->price->term)}}</td>
                                        <td class="text-nowrap">
                                            {{number_format(now()->diffInDays(Carbon\Carbon::parse($server->price->next_due_date), false), 0)}}
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
                                                <i class="fas fa-plug mx-1" id="{{$server->hostname}}"
                                                   title="check if up"
                                                   @click="checkIfUp">
                                                </i>
                                                <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                                   id="{{$server->id}}" title="{{$server->hostname}}"></i>
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
                                        <td class="text-center">{!!App\Models\Server::osIntToIcon($server->os->id, $server->os->name)!!}</td>
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
                                        <td class="text-nowrap">{{ $server->location->name }}</td>
                                        <td class="text-nowrap">{{ $server->provider->name }}</td>
                                        <td class="text-nowrap">{{ $server->price->price }} {{$server->price->currency}} {{\App\Process::paymentTermIntToString($server->price->term)}}</td>
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

                                                <i class="fas fa-plug mx-1" id="{{$server->hostname}}"
                                                   title="check if up"
                                                   @click="checkIfUp">
                                                </i>
                                                <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                                   id="{{$server->id}}" title="{{$server->hostname}}"></i>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-4 py-2 border text-red-500" colspan="3">No non-active servers found.
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>
            <x-details-footer></x-details-footer>
        </div>
        <x-delete-confirm-modal></x-delete-confirm-modal>
    </div>
    @section('scripts')
        <script>
            window.addEventListener('load', function () {
                document.getElementById("confirmDeleteModal").classList.remove("d-none");
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
                        checkIfUp(event) {
                            var hostname = event.target.id;

                            if (hostname) {
                                axios
                                    .get('/api/online/' + event.target.id, {headers: {'Authorization': 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content')}})
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
                        confirmDeleteModal(event) {
                            this.showModal = true;
                            this.modal_hostname = event.target.title;
                            this.modal_id = event.target.id;
                            this.delete_form_action = 'servers/' + this.modal_id;
                        }
                    }
                });
            })
        </script>
        <script>
            window.addEventListener('load', function () {
                $('#servers-table').DataTable({
                    "pageLength": 15,
                    "lengthMenu": [5, 10, 15, 25, 30, 50, 75, 100],
                    "columnDefs": [
                        {"orderable": false, "targets": [1,11]}
                    ],
                    "initComplete": function () {
                        $('.dataTables_length,.dataTables_filter').addClass('mb-2');
                        $('.dataTables_paginate').addClass('mt-2');
                        $('.dataTables_info').addClass('mt-2 text-muted ');
                    }
                });
            })
        </script>
    @endsection
</x-app-layout>
