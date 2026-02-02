@section("title", "Note $note->id")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <div>
                <h2 class="page-title">
                    @if($note->server !== null)
                        {{ $note->server->hostname }}
                        <small class="text-muted">(server)</small>
                    @elseif($note->shared !== null)
                        {{ $note->shared->main_domain }}
                        <small class="text-muted">(shared)</small>
                    @elseif($note->reseller !== null)
                        {{ $note->reseller->main_domain }}
                        <small class="text-muted">(reseller)</small>
                    @elseif($note->domain !== null)
                        {{ $note->domain->domain }}.{{ $note->domain->extension }}
                        <small class="text-muted">(domain)</small>
                    @elseif($note->dns !== null)
                        {{ $note->dns->dns_type }} {{ $note->dns->hostname }}
                        <small class="text-muted">(DNS)</small>
                    @elseif($note->ip !== null)
                        {{ $note->ip->address }}
                        <small class="text-muted">(IP)</small>
                    @endif
                </h2>
            </div>
            <div class="page-actions">
                <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">Back to notes</a>
                <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="detail-card">
            <div class="detail-section">
                <div class="detail-section-header">
                    <h6 class="detail-section-title">Note Content</h6>
                </div>
                <div class="detail-note">{{ $note->note }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
