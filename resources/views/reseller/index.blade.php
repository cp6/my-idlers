@extends('layouts.index')
@section('title', 'Resellers')
@section('css_style')
    <x-modal-style></x-modal-style>
@endsection
@section('header')
    {{ __('Reseller') }}
@endsection
@section('content')
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <div class="card shadow mt-3">
            <div class="card-body">
                <a href="{{ route('reseller.create') }}" class="btn btn-primary mb-3">Add a reseller</a>
                <x-response-alerts></x-response-alerts>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Accounts</th>
                            <th>Location</th>
                            <th>Provider</th>
                            <th>Disk</th>
                            <th>Domains</th>
                            <th>Price</th>
                            <th>Due</th>
                            <th>Had since</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($resellers))
                            @foreach($resellers as $row)
                                <tr>
                                    <td>{{ $row->main_domain }}</td>
                                    <td>{{ $row->reseller_type }}</td>
                                    <td>{{ $row->accounts }}</td>
                                    <td class="text-nowrap">{{ $row->location->name }}</td>
                                    <td class="text-nowrap">{{ $row->provider->name }}</td>
                                    <td>{{ $row->disk_as_gb }} <small>GB</small></td>
                                    <td>{{ $row->domains_limit }}</td>
                                    <td>{{ $row->price->price }} {{$row->price->currency}} {{\App\Process::paymentTermIntToString($row->price->term)}}</td>
                                    <td>{{Carbon\Carbon::parse($row->price->next_due_date)->diffForHumans()}}</td>
                                    <td class="text-nowrap">{{ $row->owned_since }}</td>
                                    <td class="text-nowrap">
                                        <form action="{{ route('reseller.destroy', $row->id) }}" method="POST">
                                            <a href="{{ route('reseller.show', $row->id) }}"
                                               class="text-body mx-1"><i class="fas fa-eye" title="view"></i></a>
                                            <a href="{{ route('reseller.edit', $row->id) }}"
                                               class="text-body mx-1"><i class="fas fa-pen" title="edit"></i></a>
                                            <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                               id="{{$row->id}}" title="{{$row->main_domain}}"></i>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="px-4 py-2 border text-red-500" colspan="3">No reseller hosting found.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <x-details-footer></x-details-footer>
    </div>
    <x-modal-delete-script>
        <x-slot name="uri">reseller</x-slot>
    </x-modal-delete-script>
@endsection
