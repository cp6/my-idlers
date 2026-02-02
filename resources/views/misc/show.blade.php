@section("title", "{$misc_data->name} service")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">{{ $misc_data->name }}</h2>
                @if($misc_data->active !== 1)
                    <div class="mt-2">
                        <span class="badge bg-danger">Not Active</span>
                    </div>
                @endif
            </div>
            <div class="page-actions">
                <a href="{{ route('misc.index') }}" class="btn btn-outline-secondary">Back to misc</a>
                <a href="{{ route('misc.edit', $misc_data->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="row g-4">
            <!-- Service Details -->
            <div class="col-12 col-lg-6">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Service Details</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 40%;">Service</td>
                                <td class="px-3 py-2">{{ $misc_data->name }}</td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Price</td>
                                <td class="px-3 py-2">
                                    {{ $misc_data->price->price }} {{ $misc_data->price->currency }}
                                    <small class="text-muted">{{ \App\Process::paymentTermIntToString($misc_data->price->term) }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Next Due Date</td>
                                <td class="px-3 py-2">
                                    {{ Carbon\Carbon::parse($misc_data->price->next_due_date)->diffForHumans() }}
                                    <small class="text-muted">({{ Carbon\Carbon::parse($misc_data->price->next_due_date)->format('d/m/Y') }})</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Owned Since</td>
                                <td class="px-3 py-2">
                                    @if($misc_data->owned_since !== null)
                                        {{ date_format(new DateTime($misc_data->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="col-12 col-lg-6">
                <div class="card content-card">
                    <div class="card-header card-section-header">
                        <h5 class="card-section-title mb-0">Record Info</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td class="px-3 py-2 text-muted" style="width: 40%;">ID</td>
                                <td class="px-3 py-2"><code>{{ $misc_data->id }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Created</td>
                                <td class="px-3 py-2">
                                    @if($misc_data->created_at !== null)
                                        {{ date_format(new DateTime($misc_data->created_at), 'jS M Y, g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-3 py-2 text-muted">Updated</td>
                                <td class="px-3 py-2">
                                    @if($misc_data->updated_at !== null)
                                        {{ date_format(new DateTime($misc_data->updated_at), 'jS M Y, g:i a') }}
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
