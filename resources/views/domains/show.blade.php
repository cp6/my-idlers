@section("title", "{$domain_info->domain}.{$domain_info->extension} domain")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $domain_info->domain }}.{{ $domain_info->extension }}</h2>
                <div class="mt-2">
                    @foreach($domain_info->labels as $label)
                        <span class="badge bg-primary">{{$label->label->label}}</span>
                    @endforeach
                    @if($domain_info->active !== 1)
                        <span class="badge bg-danger">Not Active</span>
                    @endif
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('domains.index') }}" class="btn btn-outline-secondary">Back to domains</a>
                <a href="{{ route('domains.edit', $domain_info->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="row g-4">
            <!-- Domain Details -->
            <div class="col-12 col-lg-6">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Domain Details</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 40%;">Domain</td>
                                <td class="px-3 py-2">
                                    <a href="https://{{ $domain_info->domain }}.{{ $domain_info->extension }}" class="text-decoration-none">
                                        {{ $domain_info->domain }}.{{ $domain_info->extension }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Provider</td>
                                <td class="px-3 py-2">{{ $domain_info->provider->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Price</td>
                                <td class="px-3 py-2">
                                    {{ $domain_info->price->price }} {{ $domain_info->price->currency }}
                                    <small class="text-muted">{{ \App\Process::paymentTermIntToString($domain_info->price->term) }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Next Due Date</td>
                                <td class="px-3 py-2">
                                    {{ Carbon\Carbon::parse($domain_info->price->next_due_date)->diffForHumans() }}
                                    <small class="text-muted">({{ Carbon\Carbon::parse($domain_info->price->next_due_date)->format('d/m/Y') }})</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Owned Since</td>
                                <td class="px-3 py-2">
                                    @if($domain_info->owned_since !== null)
                                        {{ date_format(new DateTime($domain_info->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Nameservers -->
            <div class="col-12 col-lg-6">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Nameservers</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 40%;">NS1</td>
                                <td class="px-3 py-2">{{ $domain_info->ns1 }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">NS2</td>
                                <td class="px-3 py-2">{{ $domain_info->ns2 }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">NS3</td>
                                <td class="px-3 py-2">{{ $domain_info->ns3 }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(isset($domain_info->note))
            <!-- Note -->
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Note</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $domain_info->note->note }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Timestamps -->
            <div class="col-12">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Record Info</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 20%;">ID</td>
                                <td class="px-3 py-2"><code>{{ $domain_info->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Created</td>
                                <td class="px-3 py-2">
                                    @if($domain_info->created_at !== null)
                                        {{ date_format(new DateTime($domain_info->created_at), 'jS M Y, g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Updated</td>
                                <td class="px-3 py-2">
                                    @if($domain_info->updated_at !== null)
                                        {{ date_format(new DateTime($domain_info->updated_at), 'jS M Y, g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
