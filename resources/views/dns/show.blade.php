@section("title", "{$dns->hostname} {$dns->dns_type} DNS")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $dns->hostname }}</h2>
                <div class="mt-2">
                    @foreach($labels as $label)
                        <span class="badge bg-primary">{{ $label->label }}</span>
                    @endforeach
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('dns.index') }}" class="btn btn-outline-secondary">Back to DNS</a>
                <a href="{{ route('dns.edit', $dns->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="card content-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">Type</td>
                                <td class="px-2 py-2">{{ $dns->dns_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Name</td>
                                <td class="px-2 py-2">{{ $dns->hostname }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Address</td>
                                <td class="px-2 py-2"><code>{{ $dns->address }}</code></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-lg-6">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 text-muted" style="width: 40%;">Server</td>
                                <td class="px-2 py-2">
                                    @if(isset($dns->server_id))
                                        <a href="{{ route('servers.show', $dns->server_id) }}">{{ $dns->server_id }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Shared</td>
                                <td class="px-2 py-2">
                                    @if(isset($dns->shared_id))
                                        <a href="{{ route('shared.show', $dns->shared_id) }}">{{ $dns->shared_id }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Reseller</td>
                                <td class="px-2 py-2">
                                    @if(isset($dns->reseller_id))
                                        <a href="{{ route('reseller.show', $dns->reseller_id) }}">{{ $dns->reseller_id }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-muted">Domain</td>
                                <td class="px-2 py-2">
                                    @if(isset($dns->domain_id))
                                        <a href="{{ route('domains.show', $dns->domain_id) }}">{{ $dns->domain_id }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(isset($dns->note))
                <hr class="my-3">
                <h6 class="text-muted mb-2">Note</h6>
                <p class="mb-0">{{ $dns->note->note }}</p>
                @endif

                <hr class="my-3">
                <small class="text-muted">
                    ID: <code>{{ $dns->id }}</code> |
                    Created: {{ $dns->created_at !== null ? date_format(new DateTime($dns->created_at), 'jS M Y, g:i a') : '-' }} |
                    Updated: {{ $dns->updated_at !== null ? date_format(new DateTime($dns->updated_at), 'jS M Y, g:i a') : '-' }}
                </small>
            </div>
        </div>
    </div>
</x-app-layout>
