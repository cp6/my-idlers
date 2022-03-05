@section('title') {{'Edit domain'}} @endsection
<x-app-layout>
    <x-slot name="header">
        Edit {{ $domain->domain }}.{{ $domain->extension }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Domain information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('domains.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-errors-alert></x-errors-alert>
            <form action="{{ route('domains.update', $domain->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mt-4">
                    <div class="col-12 col-lg-4 mb-4">
                        <input type="hidden" value="1" name="service_type">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">domain</span></div>
                            <input type="text"
                                   class="form-control"
                                   name="domain"
                                   value="{{ $domain->domain }}">
                            @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">Extension</x-slot>
                            <x-slot name="name">extension</x-slot>
                            <x-slot name="value">{{ $domain->extension }}</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS1</x-slot>
                            <x-slot name="name">ns1</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{$domain->ns1}}</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS2</x-slot>
                            <x-slot name="name">ns2</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{$domain->ns2}}</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS3</x-slot>
                            <x-slot name="name">ns3</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{$domain->ns3}}</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <x-providers-select>
                            <x-slot name="current">
                                {{$domain->provider_id}}
                            </x-slot>
                        </x-providers-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Price</x-slot>
                            <x-slot name="name">price</x-slot>
                            <x-slot name="step">0.01</x-slot>
                            <x-slot name="value">{{ $domain_info[0]->price }}</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-term-select>
                            <x-slot name="current">{{$domain_info[0]->term}}</x-slot>
                        </x-term-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-currency-select>
                            <x-slot name="current">{{$domain_info[0]->currency}}</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Owned since</x-slot>
                            <x-slot name="name">owned_since</x-slot>
                            <x-slot name="value">{{$domain_info[0]->owned_since }}</x-slot>
                        </x-date-input>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Next due date</x-slot>
                            <x-slot name="name">next_due_date</x-slot>
                            <x-slot name="value">{{$domain_info[0]->next_due_date}}</x-slot>
                        </x-date-input>
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
                           value="1" {{ ($domain_info[0]->active === 1) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        I still have this service
                    </label>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Update domain</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
