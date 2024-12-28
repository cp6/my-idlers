@section('title', 'IP addresses')
<x-app-layout>
    <x-slot name="header">
        {{ __('IP addresses') }}
    </x-slot>
    <div class="container" id="app">
            <x-response-alerts></x-response-alerts>
            <x-card class="shadow mt-3">
                <a href="{{ route('IPs.create') }}" class="btn btn-primary mb-3">Add IP</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="ips-table">
                        <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">Type</th>
                            <th class="text-nowrap">Address</th>
                            <th class="text-nowrap">Country</th>
                            <th class="text-nowrap">City</th>
                            <th class="text-nowrap">ORG</th>
                            <th class="text-nowrap">ASN</th>
                            <th class="text-nowrap">ISP</th>
                            <th class="text-nowrap">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($ips))
                            @foreach($ips as $ip)
                                <tr>
                                    <td class="text-nowrap">@if ($ip->is_ipv4 === 1)
                                            IPv4
                                        @else
                                            IPv6
                                        @endif</td>
                                    <td class="text-nowrap">{{ $ip->address}}</td>
                                    <td class="text-nowrap">{{ $ip->country}}</td>
                                    <td class="text-nowrap">{{ $ip->city}}</td>
                                    <td class="text-nowrap">{{ $ip->org}}</td>
                                    <td class="text-nowrap">{{ $ip->asn}}</td>
                                    <td class="text-nowrap">{{ $ip->isp}}</td>
                                    <td class="text-nowrap">
                                        <form action="{{ route('IPs.destroy', $ip->id) }}" method="POST">
                                            <a href="{{ route('ip.pull.info', $ip->id) }}"
                                               class="text-body mx-1">
                                                <i class="fa-solid fa-arrows-rotate" title="Pull IP info"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                               id="{{$ip->id}}" title="{{$ip->address}}"></i>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="px-4 py-2 border text-red-500" colspan="3">No IPs found.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </x-card>
        <x-details-footer></x-details-footer>
        <x-delete-confirm-modal></x-delete-confirm-modal>
    </div>
    <x-modal-delete-script>
        <x-slot name="uri">IPs</x-slot>
    </x-modal-delete-script>
    @section('scripts')
        <script>
            window.addEventListener('load', function () {
                $('#ips-table').DataTable({
                    "pageLength": 15,
                    "lengthMenu": [5, 10, 15, 25, 30, 50, 75, 100],
                    "columnDefs": [
                        {"orderable": false, "targets": 1}
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

