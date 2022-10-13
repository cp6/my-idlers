@section('title') {{'Seed boxes'}} @endsection
@section('style')
    <x-modal-style></x-modal-style>
@endsection
@section('scripts')
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Seed boxes') }}
    </x-slot>
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <div class="card shadow mt-3">
            <div class="card-body">
                <a href="{{ route('seedboxes.create') }}" class="btn btn-primary mb-3">Add a seed box</a>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        <p class="my-1">{{ $message }}</p>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr class="bg-gray-100">
                            <th>Title</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Provider</th>
                            <th>Disk</th>
                            <th>BWidth</th>
                            <th>Port</th>
                            <th>Price</th>
                            <th>Due</th>
                            <th>Had since</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($seedboxes[0]))
                            @foreach($seedboxes as $row)
                                <tr>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->seed_box_type }}</td>
                                    <td class="text-nowrap">{{ $row->location->name }}</td>
                                    <td class="text-nowrap">{{ $row->provider->name }}</td>
                                    <td>
                                        @if($row->disk_as_gb >= 1000)
                                            {{ number_format($row->disk_as_gb / 1000,1) }} <small>TB</small>
                                        @else
                                            {{ $row->disk_as_gb }} <small>GB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->bandwidth >= 1000)
                                            {{ number_format($row->bandwidth / 1000,1) }} <small>TB</small>
                                        @else
                                            {{ $row->bandwidth }} <small>GB</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row->port_speed >= 1000)
                                            {{ number_format($row->port_speed / 1000,1) }} <small>Gbps</small>
                                        @else
                                            {{ $row->port_speed }} <small>Mbps</small>
                                        @endif
                                    </td>
                                    <td>{{ $row->price->price }} {{$row->price->currency}} {{\App\Process::paymentTermIntToString($row->price->term)}}</td>
                                    <td>{{Carbon\Carbon::parse($row->price->next_due_date)->diffForHumans()}}</td>
                                    <td class="text-nowrap">{{ $row->owned_since }}</td>
                                    <td class="text-nowrap">
                                        <form action="{{ route('seedboxes.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            <a href="{{ route('seedboxes.show', $row->id) }}"
                                               class="text-body mx-1">
                                                <i class="fas fa-eye" title="view"></i>
                                            </a>
                                            <a href="{{ route('seedboxes.edit', $row->id) }}"
                                               class="text-body mx-1">
                                                <i class="fas fa-pen" title="edit"></i>
                                            </a>
                                            <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                               id="{{$row->id}}" title="{{$row->title}}"></i>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="px-4 py-2 border text-red-500" colspan="3">No seed boxes found.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>Built on Laravel
                    v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</small></p>
        @endif
    </div>

    <script>
        let app = new Vue({
            el: "#app",
            data: {
                "modal_hostname": '',
                "modal_id": '',
                "delete_form_action": '',
                showModal: false
            },
            methods: {
                confirmDeleteModal(event) {
                    this.showModal = true;
                    this.modal_hostname = event.target.title;
                    this.modal_id = event.target.id;
                    this.delete_form_action = 'seedboxes/' + this.modal_id;
                }
            }
        });
    </script>
</x-app-layout>
