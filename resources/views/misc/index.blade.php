@section("title", "Misc services")
@section('style')
    <x-modal-style></x-modal-style>
@endsection
@section('scripts')
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Misc services') }}
    </x-slot>
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <x-card class="shadow mt-3">
            <a href="{{ route('misc.create') }}" class="btn btn-primary mb-3">Add misc service</a>
            <x-response-alerts></x-response-alerts>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">Name</th>
                        <th class="text-nowrap">Owned since</th>
                        <th class="text-nowrap">Due in</th>
                        <th class="text-nowrap">Price</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($misc[0]))
                        @foreach($misc as $m)
                            <tr>
                                <td class="text-nowrap">{{$m->name}}</td>
                                <td class="text-nowrap">
                                    @if(!is_null($m->owned_since))
                                        {{ date_format(new DateTime($m->owned_since), 'jS F Y') }}
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ now()->diffInDays($m->price->next_due_date) }}
                                    <small>days</small></td>
                                <td class="text-nowrap">{{$m->price->price}} {{$m->price->currency}}
                                    <small>{{\App\Process::paymentTermIntToString($m->price->term)}}</small></td>
                                <td class="text-nowrap">
                                    <form action="{{ route('misc.destroy', $m->id) }}" method="POST">
                                        <a href="{{ route('misc.edit', $m->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-pen" title="edit"></i></a>
                                        <a href="{{ route('misc.show', $m->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-eye" title="view"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                           id="{{$m->name}}" title="{{$m->id}}"></i>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="px-4 py-2 border text-red-500" colspan="3">No misc services found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </x-card>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
    <x-modal-delete-script>
        <x-slot name="uri">misc</x-slot>
    </x-modal-delete-script>
</x-app-layout>
