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

            <div class="tab-content p-3">
                <div class="tab-pane fade show active" id="active-servers" role="tabpanel">
                    <div class="row g-3">
                        @if(!empty($servers))
                            @foreach($servers as $server)
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="server-card">
                                    <div class="server-card-header">
                                        <div class="server-info">
                                            <div class="server-os-icon">
                                                {!! App\Models\Server::osIntToIcon($server->os->id ?? 1, $server->os->name ?? 'Unknown') !!}
                                            </div>
                                            <div class="server-title">
                                                <h5 class="server-hostname">{{ $server->hostname }}</h5>
                                                <span class="server-location">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $server->location->name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="server-actions">
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
                                    </div>
                                    
                                    <div class="server-card-body">
                                        <div class="server-specs">
                                            <div class="spec-item">
                                                <div class="spec-details">
                                                    <span class="spec-value">{{ $server->cpu }}</span>
                                                    <span class="spec-label">vCPU</span>
                                                </div>
                                            </div>
                                            <div class="spec-item">
                                                <div class="spec-details">
                                                    <span class="spec-value">{{ $server->ram }} {{ $server->ram_type }}</span>
                                                    <span class="spec-label">RAM</span>
                                                </div>
                                            </div>
                                            <div class="spec-item">
                                                <div class="spec-details">
                                                    <span class="spec-value">{{ $server->disk }} {{ $server->disk_type }}</span>
                                                    <span class="spec-label">Disk</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="server-meta">
                                            <div class="meta-row">
                                                <span class="meta-label">Provider</span>
                                                <span class="meta-value">{{ $server->provider->name }}</span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-label">OS</span>
                                                <span class="meta-value">{{ $server->os->name ?? 'Unknown' }}</span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-label">Type</span>
                                                <span class="meta-value">{{ App\Models\Server::serviceServerType($server->server_type) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="server-card-footer">
                                        <div class="server-price">
                                            <span class="price-amount">{{ $server->price->currency }} {{ number_format($server->price->price, 2) }}</span>
                                            <span class="price-term">{{ \App\Process::paymentTermIntToString($server->price->term) }}</span>
                                        </div>
                                        <div class="server-due">
                                            @php
                                                $daysUntilDue = (int) now()->diffInDays(\Carbon\Carbon::parse($server->price->next_due_date), false);
                                            @endphp
                                            <span class="due-badge {{ $daysUntilDue <= 7 ? 'due-soon' : ($daysUntilDue <= 14 ? 'due-warning' : '') }}">
                                                @if($daysUntilDue < 0)
                                                    {{ abs($daysUntilDue) }}d overdue
                                                @elseif($daysUntilDue == 0)
                                                    Due today
                                                @else
                                                    {{ $daysUntilDue }}d until due
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    @if(isset($server->yabs[0]))
                                    <div class="server-yabs-badge">
                                        <i class="fas fa-chart-bar"></i> YABS
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-server fa-3x mb-3 opacity-50"></i>
                                    <p>No active servers found</p>
                                    <a href="{{ route('servers.create') }}" class="btn btn-primary btn-sm">Add your first server</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="inactive-servers" role="tabpanel">
                    <div class="row g-3">
                        @if(!empty($non_active_servers))
                            @foreach($non_active_servers as $server)
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="server-card server-card-inactive">
                                    <div class="server-card-header">
                                        <div class="server-info">
                                            <div class="server-os-icon">
                                                {!! App\Models\Server::osIntToIcon($server->os->id ?? 1, $server->os->name ?? 'Unknown') !!}
                                            </div>
                                            <div class="server-title">
                                                <h5 class="server-hostname">{{ $server->hostname }}</h5>
                                                <span class="server-location">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $server->location->name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="server-actions">
                                            <a href="{{ route('servers.show', $server->id) }}" class="btn btn-sm btn-action" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('servers.edit', $server->id) }}" class="btn btn-sm btn-action" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                                    @click="confirmDeleteModal" id="{{ $server->id }}" data-title="{{ $server->hostname }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="server-card-body">
                                        <div class="server-specs">
                                            <div class="spec-item">
                                                <div class="spec-details">
                                                    <span class="spec-value">{{ $server->cpu }}</span>
                                                    <span class="spec-label">vCPU</span>
                                                </div>
                                            </div>
                                            <div class="spec-item">
                                                <div class="spec-details">
                                                    <span class="spec-value">{{ $server->ram }} {{ $server->ram_type }}</span>
                                                    <span class="spec-label">RAM</span>
                                                </div>
                                            </div>
                                            <div class="spec-item">
                                                <div class="spec-details">
                                                    <span class="spec-value">{{ $server->disk }} {{ $server->disk_type }}</span>
                                                    <span class="spec-label">Disk</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="server-meta">
                                            <div class="meta-row">
                                                <span class="meta-label">Provider</span>
                                                <span class="meta-value">{{ $server->provider->name }}</span>
                                            </div>
                                            <div class="meta-row">
                                                <span class="meta-label">OS</span>
                                                <span class="meta-value">{{ $server->os->name ?? 'Unknown' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="server-card-footer">
                                        <div class="server-price">
                                            <span class="price-amount">{{ $server->price->currency }} {{ number_format($server->price->price, 2) }}</span>
                                            <span class="price-term">{{ \App\Process::paymentTermIntToString($server->price->term) }}</span>
                                        </div>
                                        <span class="badge bg-secondary">Inactive</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="text-center text-muted py-5">
                                    <p>No inactive servers</p>
                                </div>
                            </div>
                        @endif
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
        });
    </script>
    @endsection

    @section('style')
    <style>
        .server-card {
            background: var(--bs-body-bg, #fff);
            border: 1px solid var(--bs-border-color, #dee2e6);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .server-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .server-card-inactive {
            opacity: 0.7;
        }

        .server-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1rem 1rem 0.75rem;
            border-bottom: 1px solid var(--bs-border-color, #eee);
            background: var(--bs-tertiary-bg, #f8f9fa);
        }

        .server-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-width: 0;
            flex: 1;
        }

        .server-os-icon {
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bs-body-bg, #fff);
            border-radius: 8px;
            flex-shrink: 0;
        }

        .server-title {
            min-width: 0;
        }

        .server-hostname {
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--bs-body-color);
        }

        .server-location {
            font-size: 0.75rem;
            color: var(--bs-secondary-color, #6c757d);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .server-actions {
            display: flex;
            gap: 0.25rem;
            flex-shrink: 0;
        }

        .server-actions .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .server-card-body {
            padding: 1rem;
            flex: 1;
        }

        .server-specs {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px dashed var(--bs-border-color, #eee);
        }

        .spec-item {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            min-width: 0;
            text-align: center;
        }

        .spec-details {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .spec-value {
            font-weight: 700;
            font-size: 0.95rem;
            line-height: 1.2;
            color: var(--bs-body-color);
        }

        .spec-label {
            font-size: 0.7rem;
            color: var(--bs-secondary-color, #6c757d);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .server-meta {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
        }

        .meta-label {
            color: var(--bs-secondary-color, #6c757d);
        }

        .meta-value {
            font-weight: 500;
            color: var(--bs-body-color);
            text-align: right;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 60%;
        }

        .server-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background: var(--bs-tertiary-bg, #f8f9fa);
            border-top: 1px solid var(--bs-border-color, #eee);
            margin-top: auto;
        }

        .server-price {
            display: flex;
            flex-direction: column;
        }

        .price-amount {
            font-weight: 700;
            font-size: 1rem;
            color: var(--bs-success, #198754);
        }

        .price-term {
            font-size: 0.7rem;
            color: var(--bs-secondary-color, #6c757d);
            text-transform: uppercase;
        }

        .due-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.6rem;
            border-radius: 20px;
            background: var(--bs-secondary-bg, #e9ecef);
            color: var(--bs-secondary-color, #6c757d);
            font-weight: 500;
        }

        .due-badge.due-warning {
            background: #fff3cd;
            color: #856404;
        }

        .due-badge.due-soon {
            background: #f8d7da;
            color: #721c24;
        }

        .server-yabs-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 0.65rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: none;
        }

        </style>
    @endsection
</x-app-layout>
