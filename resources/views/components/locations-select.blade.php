<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{ $title ??'Location'}}</span></div>
    <select class="form-control" name="{{$name ?? 'location_id'}}">
        @foreach ($locations as $location)
            <option
                value="{{ $location['id'] }}" {{(isset($current) && (string)$current === (string)$location['id'])? 'selected' : ''}}>
                {{ $location['name'] }}
            </option>
        @endforeach
    </select>
</div>
