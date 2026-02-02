@section('title', 'Servers')
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Servers</h2>
            <div class="page-actions">
                <a href="{{ route('servers.create') }}" class="btn btn-primary">Add server</a>
                <a href="{{ route('servers-compare-choose') }}" class="btn btn-outline-secondary">Compare</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="content-card">
            <div class="card-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active-servers" 
                                type="button" role="tab" aria-selected="true">
                            Active <span class="badge bg-secondary ms-1">{{ count($servers ?? []) }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if(!isset($non_active_servers[0])) disabled @endif" id="inactive-tab" 
                                data-bs-toggle="tab" data-bs-target="#inactive-servers" type="button" role="tab" aria-selected="false">
                            Inactive <span class="badge bg-secondary ms-1">{{ count($non_active_servers ?? []) }}</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="active-servers" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table data-table" id="servers-table">
                            <thead>
                                <tr>
                                    <th>Hostname</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">OS</th>
                                    <th class="text-center">CPU</th>
                                    <th class="text-center">RAM</th>
                                    <th class="text-center">Disk</th>
                                    <th>Location</th>
                                    <th>Provider</th>
                                    <th>Price</th>
                                    <th class="text-center">Due</th>
                                    <th class="text-center">Since</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($servers))
                                @foreach($servers as $server)
                                <tr>
                                    <td class="fw-medium">{{ $server->hostname }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-type">{{ App\Models\Server::serviceServerType($server->server_type) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if(isset($server->os))
                                            <span title="{{ $server->os->name }}">{!! App\Models\Server::osIntToIcon($server->os->id, $server->os->name) !!}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $server->cpu }}</td>
                                    <td class="text-center text-nowrap">
                                        {{ $server->ram }}<small class="text-muted">{{ $server->ram_type }}</small>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{ $server->disk }}<small class="text-muted">{{ $server->disk_type }}</small>
                                    </td>
                                    <td class="text-nowrap">{{ $server->location->name }}</td>
                                    <td class="text-nowrap">{{ $server->provider->name }}</td>
                                    <td class="text-nowrap">
                                        {{ $server->price->price }} {{ $server->price->currency }}
                                        <small class="text-muted">{{ \App\Process::paymentTermIntToString($server->price->term) }}</small>
                                    </td>
                                    <td class="text-center text-nowrap">
                                        {{ number_format(now()->diffInDays(Carbon\Carbon::parse($server->price->next_due_date), false), 0) }}d
                                    </td>
                                    <td class="text-center text-nowrap">{{ $server->owned_since }}</td>
                                    <td class="text-center text-nowrap">
                                        <div class="action-buttons">
                                            <a href="{{ route('servers.show', $server->id) }}" class="btn btn-sm btn-action" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('servers.edit', $server->id) }}" class="btn btn-sm btn-action" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-action" title="Check status" 
                                                    id="{{ $server->hostname }}" @click="checkIfUp">
                                                <i class="fas fa-plug" id="{{ $server->hostname }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                                    @click="confirmDeleteModal" id="{{ $server->id }}" data-title="{{ $server->hostname }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" class="text-center text-muted py-4">No active servers found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="inactive-servers" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table data-table">
                            <thead>
                                <tr>
                                    <th>Hostname</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">OS</th>
                                    <th class="text-center">CPU</th>
                                    <th class="text-center">RAM</th>
                                    <th class="text-center">Disk</th>
                                    <th>Location</th>
                                    <th>Provider</th>
                                    <th>Price</th>
                                    <th class="text-center">Since</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($non_active_servers))
                                @foreach($non_active_servers as $server)
                                <tr>
                                    <td class="fw-medium">{{ $server->hostname }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-type">{{ App\Models\Server::serviceServerType($server->server_type) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if(isset($server->os))
                                            <span title="{{ $server->os->name }}">{!! App\Models\Server::osIntToIcon($server->os->id, $server->os->name) !!}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $server->cpu }}</td>
                                    <td class="text-center text-nowrap">
                                        @if($server->ram_as_mb > 1024)
                                            {{ number_format($server->ram_as_mb / 1024, 0) }}<small class="text-muted">GB</small>
                                        @else
                                            {{ $server->ram_as_mb }}<small class="text-muted">MB</small>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        @if($server->disk > 1000)
                                            {{ number_format($server->disk / 1024, 1) }}<small class="text-muted">TB</small>
                                        @else
                                            {{ $server->disk }}<small class="text-muted">GB</small>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">{{ $server->location->name }}</td>
                                    <td class="text-nowrap">{{ $server->provider->name }}</td>
                                    <td class="text-nowrap">
                                        {{ $server->price->price }} {{ $server->price->currency }}
                                        <small class="text-muted">{{ \App\Process::paymentTermIntToString($server->price->term) }}</small>
                                    </td>
                                    <td class="text-center text-nowrap">{{ $server->owned_since }}</td>
                                    <td class="text-center text-nowrap">
                                        <div class="action-buttons">
                                            <a href="{{ route('servers.show', $server->id) }}" class="btn btn-sm btn-action" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('servers.edit', $server->id) }}" class="btn btn-sm btn-action" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-action" title="Check status"
                                                    id="{{ $server->hostname }}" @click="checkIfUp">
                                                <i class="fas fa-plug" id="{{ $server->hostname }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                                    @click="confirmDeleteModal" id="{{ $server->id }}" data-title="{{ $server->hostname }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-4">No inactive servers found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <x-details-footer></x-details-footer>
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
                    status: false,
                    modal_hostname: '',
                    modal_id: '',
                    delete_form_action: '',
                    showModal: false
                },
                methods: {
                    checkIfUp(event) {
                        var el = event.target.closest('button') || event.target;
                        var hostname = el.id || event.target.id;
                        var icon = el.querySelector('i') || event.target;

                        if (hostname) {
                            axios
                                .get('/api/online/' + hostname, {
                                    headers: {'Authorization': 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content')}
                                })
                                .then(response => (this.status = response.data.is_online))
                                .finally(() => {
                                    icon.classList.remove('text-success', 'text-danger');
                                    icon.classList.add(this.status ? 'text-success' : 'text-danger');
                                });
                        }
                    },
                    confirmDeleteModal(event) {
                        var el = event.target.closest('button') || event.target;
                        this.showModal = true;
                        this.modal_hostname = el.dataset.title || el.title;
                        this.modal_id = el.id;
                        this.delete_form_action = 'servers/' + this.modal_id;
                    }
                }
            });

            $.fn.dataTable.ext.errMode = 'none';
            $('#servers-table').DataTable({
                pageLength: 15,
                lengthMenu: [5, 10, 15, 25, 50, 100],
                columnDefs: [
                    {orderable: false, targets: [2, 11]}
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search servers...",
                    lengthMenu: "Show _MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    },
                    emptyTable: "No servers found"
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
