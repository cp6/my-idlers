@section('title', 'YABS results')
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">YABS Results</h2>
            <div class="page-actions">
                <a href="{{ route('yabs.compare-choose') }}" class="btn btn-outline-secondary">Compare YABS</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="content-card">
            <div class="table-responsive">
                <table class="table data-table" id="yabs-table">
                    <thead>
                        <tr>
                            <th>Server</th>
                            <th class="text-center">CPU</th>
                            <th class="text-center">Freq</th>
                            <th class="text-center">RAM</th>
                            <th class="text-center">Disk</th>
                            <th class="text-center">GB5 S</th>
                            <th class="text-center">GB5 M</th>
                            <th class="text-center">IPv6</th>
                            <th class="text-center">4k</th>
                            <th class="text-center">64k</th>
                            <th class="text-center">512k</th>
                            <th class="text-center">1m</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($yabs))
                        @foreach($yabs as $yab)
                        <tr>
                            <td class="fw-medium">
                                <a href="{{ route('servers.show', $yab->server_id) }}" class="text-decoration-none">
                                    {{ $yab->server->hostname }}
                                </a>
                            </td>
                            <td class="text-center" title="{{ $yab->cpu_model }}">{{ $yab->cpu_cores }}</td>
                            <td class="text-center text-nowrap" title="{{ $yab->cpu_model }}">
                                {{ $yab->cpu_freq }}<small class="text-muted">MHz</small>
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $yab->ram }}<small class="text-muted">{{ $yab->ram_type }}</small>
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $yab->disk }}<small class="text-muted">{{ $yab->disk_type }}</small>
                            </td>
                            <td class="text-center">
                                <a href="https://browser.geekbench.com/v5/cpu/{{ $yab->gb5_id }}" class="text-decoration-none" target="_blank">
                                    {{ $yab->gb5_single }}
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="https://browser.geekbench.com/v5/cpu/{{ $yab->gb5_id }}" class="text-decoration-none" target="_blank">
                                    {{ $yab->gb5_multi }}
                                </a>
                            </td>
                            <td class="text-center">
                                @if($yab->has_ipv6 === 1)
                                    <span class="text-success">Yes</span>
                                @else
                                    <span class="text-muted">No</span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $yab->disk_speed->d_4k }}<small class="text-muted">{{ $yab->disk_speed->d_4k_type }}</small>
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $yab->disk_speed->d_64k }}<small class="text-muted">{{ $yab->disk_speed->d_64k_type }}</small>
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $yab->disk_speed->d_512k }}<small class="text-muted">{{ $yab->disk_speed->d_512k_type }}</small>
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $yab->disk_speed->d_1m }}<small class="text-muted">{{ $yab->disk_speed->d_1m_type }}</small>
                            </td>
                            <td class="text-center text-nowrap">{{ date_format(new DateTime($yab->output_date), 'Y-m-d') }}</td>
                            <td class="text-center text-nowrap">
                                <div class="action-buttons">
                                    <a href="{{ route('yabs.show', $yab->id) }}" class="btn btn-sm btn-action" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                            @click="confirmDeleteModal" id="{{ $yab->id }}" data-title="{{ $yab->server->hostname }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="14" class="text-center text-muted py-4">No YABS results found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <x-details-footer></x-details-footer>
        <x-delete-confirm-modal></x-delete-confirm-modal>
    </div>

    <x-modal-delete-script>
        <x-slot name="uri">yabs</x-slot>
    </x-modal-delete-script>

    @section('scripts')
    <script>
        window.addEventListener('load', function () {
            $.fn.dataTable.ext.errMode = 'none';
            $('#yabs-table').DataTable({
                pageLength: 15,
                lengthMenu: [5, 10, 15, 25, 50, 100],
                columnDefs: [
                    {orderable: false, targets: [13]}
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_",
                    paginate: { previous: "Prev", next: "Next" },
                    emptyTable: "No YABS results found"
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
