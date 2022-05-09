<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{ $title ??'Provider'}}</span></div>
    <select class="form-control" name="{{$name ?? 'provider_id'}}">
        @foreach ($providers as $provider)
            <option value="{{ $provider->id }}" {{(isset($current) && (string)$current === (string)$provider->id)? 'selected' : ''}}>
                {{ $provider->name }}
            </option>
        @endforeach
    </select>
</div>
