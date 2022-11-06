@extends('layouts.index')
@section('title', 'Domain names')
@section('css_style')
    <x-modal-style></x-modal-style>
@endsection
@section('header')
    {{ __('Domains') }}
@endsection
@section('content')
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <x-card class="shadow mt-3">
            <a href="{{ route('domains.create') }}" class="btn btn-primary mb-3">Add a domain</a>
            <x-response-alerts></x-response-alerts>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">Domain</th>
                        <th class="text-nowrap">Owned since</th>
                        <th class="text-nowrap">Due in</th>
                        <th class="text-nowrap">Provider</th>
                        <th class="text-nowrap">Price</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($domains))
                        @foreach($domains as $domain)
                            <tr>
                                <td class="text-nowrap"><a href="https://{{ $domain->domain }}.{{$domain->extension}}"
                                                           class="text-decoration-none">{{ $domain->domain }}
                                        .{{$domain->extension}}</a></td>
                                <td class="text-nowrap">{{ $domain->owned_since}}</td>
                                <td class="text-nowrap">{{ now()->diffInDays($domain->price->next_due_date) }} <small>days</small>
                                </td>
                                <td class="text-nowrap">{{ $domain->provider->name}}</td>
                                <td class="text-nowrap">{{ $domain->price->price }}
                                    <small>{{$domain->price->currency}}</small></td>
                                <td class="text-nowrap">
                                    <form action="{{ route('domains.destroy', $domain->id) }}" method="POST">
                                        <a href="{{ route('domains.show', $domain->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-eye" title="view"></i></a>
                                        <a href="{{ route('domains.edit', $domain->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-pen" title="edit"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                           id="{{$domain->id}}" title="{{$domain->domain}}"></i>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="px-4 py-2 border text-red-500" colspan="3">No domains found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </x-card>
        <x-details-footer></x-details-footer>
    </div>
    <x-modal-delete-script>
        <x-slot name="uri">domains</x-slot>
    </x-modal-delete-script>
@endsection
