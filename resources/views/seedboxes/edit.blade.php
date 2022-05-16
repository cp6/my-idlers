@section('title') {{$seedbox[0]->title}} {{'edit'}} @endsection
<x-app-layout>
    <x-slot name="header">
        Edit {{ $seedbox[0]->title }}
    </x-slot>
    <div class="container">
        <div class="card mt-3 shadow">
            <div class="card-body">
                <a href="{{ route('seedboxes.index') }}"
                   class="btn btn-primary px-4 py-1">
                    Back to seed boxes
                </a>
                <x-auth-validation-errors></x-auth-validation-errors>
                <form action="{{ route('seedboxes.update', $seedbox[0]->service_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mt-3">
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Title</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="title" value="{{$seedbox[0]->title}}">
                                @error('title') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Hostname</span></div>
                                <input type="text"
                                       class="form-control"
                                       name="hostname" value="{{$seedbox[0]->hostname}}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 mb-4">
                            <input type="hidden" name="id" value="{{$seedbox[0]->service_id}}">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                                <select class="form-control" name="seed_box_type">
                                    <option
                                        value="uTorrent" {{ ($seedbox[0]->seed_box_type === 'uTorrent') ? 'selected' : '' }}>
                                        uTorrent
                                    </option>
                                    <option
                                        value="BitTorrent" {{ ($seedbox[0]->seed_box_type === 'BitTorrent') ? 'selected' : '' }}>
                                        BitTorrent
                                    </option>
                                    <option
                                        value="ruTorrent" {{ ($seedbox[0]->seed_box_type === 'ruTorrent') ? 'selected' : '' }}>
                                        ruTorrent
                                    </option>
                                    <option
                                        value="Transmission" {{ ($seedbox[0]->seed_box_type === 'Transmission') ? 'selected' : '' }}>
                                        Transmission
                                    </option>
                                    <option
                                        value="qBitTorrent" {{ ($seedbox[0]->seed_box_type === 'qBitTorrent') ? 'selected' : '' }}>
                                        qBitTorrent
                                    </option>
                                    <option
                                        value="Zona" {{ ($seedbox[0]->seed_box_type === 'Zona') ? 'selected' : '' }}>
                                        Zona
                                    </option>
                                    <option
                                        value="Other" {{ ($seedbox[0]->seed_box_type === 'Other') ? 'selected' : '' }}>
                                        Other
                                    </option>
                                    <option
                                        value="Deluge" {{ ($seedbox[0]->seed_box_type === 'Deluge') ? 'selected' : '' }}>
                                        Deluge
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <x-providers-select>
                                <x-slot name="current">{{$seedbox[0]->provider_id}}</x-slot>
                            </x-providers-select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <x-number-input>
                                <x-slot name="title">Price</x-slot>
                                <x-slot name="name">price</x-slot>
                                <x-slot name="value">{{$seedbox[0]->price}}</x-slot>
                                <x-slot name="max">9999</x-slot>
                                <x-slot name="step">0.01</x-slot>
                                <x-slot name="required"></x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-md-3 mb-3">
                            <x-term-select>
                                <x-slot name="current">{{$seedbox[0]->term}}</x-slot>
                            </x-term-select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <x-currency-select>
                                <x-slot name="current">{{$seedbox[0]->currency}}</x-slot>
                            </x-currency-select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-md-3 mb-3">
                            <x-locations-select>
                                <x-slot name="current">{{$seedbox[0]->location_id}}</x-slot>
                            </x-locations-select>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-yes-no-select>
                                <x-slot name="title">Promo price</x-slot>
                                <x-slot name="name">was_promo</x-slot>
                                <x-slot name="value">{{ $seedbox[0]->was_promo }}</x-slot>
                            </x-yes-no-select>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-date-input>
                                <x-slot name="title">Owned since</x-slot>
                                <x-slot name="name">owned_since</x-slot>
                                <x-slot name="value">{{$seedbox[0]->owned_since }}</x-slot>
                            </x-date-input>
                        </div>
                        <div class="col-12 col-md-3 mb-3">
                            <x-date-input>
                                <x-slot name="title">Next due date</x-slot>
                                <x-slot name="name">next_due_date</x-slot>
                                <x-slot name="value">{{$seedbox[0]->next_due_date }}</x-slot>
                            </x-date-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Disk GB</x-slot>
                                <x-slot name="name">disk</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$seedbox[0]->disk_as_gb}}</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Bandwidth GB</x-slot>
                                <x-slot name="name">bandwidth</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$seedbox[0]->bandwidth}}</x-slot>
                            </x-number-input>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-number-input>
                                <x-slot name="title">Port speed GB</x-slot>
                                <x-slot name="name">port_speed</x-slot>
                                <x-slot name="value">1</x-slot>
                                <x-slot name="max">999999</x-slot>
                                <x-slot name="step">1</x-slot>
                                <x-slot name="value">{{$seedbox[0]->port_speed}}</x-slot>
                            </x-number-input>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label1</x-slot>
                                @if(isset($labels[0]->id))
                                    <x-slot name="current">{{$labels[0]->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label2</x-slot>
                                @if(isset($labels[1]->id))
                                    <x-slot name="current">{{$labels[1]->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label3</x-slot>
                                @if(isset($labels[2]->id))
                                    <x-slot name="current">{{$labels[2]->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                        <div class="col-12 col-lg-3 mb-4">
                            <x-labels-select>
                                <x-slot name="title">label</x-slot>
                                <x-slot name="name">label4</x-slot>
                                @if(isset($labels[3]->id))
                                    <x-slot name="current">{{$labels[3]->id}}</x-slot>
                                @endif
                            </x-labels-select>
                        </div>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" name="is_active" type="checkbox"
                               value="1" {{ ($seedbox[0]->active === 1) ? 'checked' : '' }}>
                        <label class="form-check-label">
                            I still have this server
                        </label>
                    </div>
                    <div>
                        <button type="submit"
                                class="btn btn-success px-4 py-1 mt-3">
                            Update seed box
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
