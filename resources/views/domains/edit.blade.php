@section("title", "Edit Domain")
<x-app-layout>
    <x-slot name="header">
        Edit {{ $domain_info->domain }}.{{ $domain_info->extension }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">Domain information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('domains.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('domains.update', $domain_info->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mt-4">
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input title="Domain" name="domain" value="{{ $domain_info->domain }}"></x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">Extension</x-slot>
                            <x-slot name="name">extension</x-slot>
                            <x-slot name="value">{{ $domain_info->extension }}</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS1</x-slot>
                            <x-slot name="name">ns1</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{$domain_info->ns1}}</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS2</x-slot>
                            <x-slot name="name">ns2</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{$domain_info->ns2}}</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">NS3</x-slot>
                            <x-slot name="name">ns3</x-slot>
                            <x-slot name="max">255</x-slot>
                            <x-slot name="value">{{$domain_info->ns3}}</x-slot>
                        </x-text-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <x-providers-select>
                            <x-slot name="current">
                                {{$domain_info->provider->id}}
                            </x-slot>
                        </x-providers-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-number-input>
                            <x-slot name="title">Price</x-slot>
                            <x-slot name="name">price</x-slot>
                            <x-slot name="step">0.01</x-slot>
                            <x-slot name="value">{{ $domain_info->price->price }}</x-slot>
                        </x-number-input>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-term-select>
                            <x-slot name="current">{{$domain_info->price->term}}</x-slot>
                        </x-term-select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <x-currency-select>
                            <x-slot name="current">{{$domain_info->price->currency}}</x-slot>
                        </x-currency-select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Owned since</x-slot>
                            <x-slot name="name">owned_since</x-slot>
                            <x-slot name="value">{{$domain_info->owned_since }}</x-slot>
                        </x-date-input>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <x-date-input>
                            <x-slot name="title">Next due date</x-slot>
                            <x-slot name="name">next_due_date</x-slot>
                            <x-slot name="value">{{$domain_info->price->next_due_date}}</x-slot>
                        </x-date-input>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label1</x-slot>
                            @if(isset($domain_info->labels[0]->label))
                                <x-slot name="current">{{$domain_info->labels[0]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label2</x-slot>
                            @if(isset($domain_info->labels[1]->label))
                                <x-slot name="current">{{$domain_info->labels[1]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label3</x-slot>
                            @if(isset($domain_info->labels[2]->label))
                                <x-slot name="current">{{$domain_info->labels[2]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label4</x-slot>
                            @if(isset($domain_info->labels[3]->label))
                                <x-slot name="current">{{$domain_info->labels[3]->label->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                </div>

                <div class="form-check mt-2">
                    <input class="form-check-input" name="is_active" type="checkbox"
                           value="1" {{ ($domain_info->active === 1) ? 'checked' : '' }}>
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
