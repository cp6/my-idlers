<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{ $title ??'OS'}}</span></div>
    <select class="form-control" name="{{$name ?? 'os_id'}}">
        @foreach ($os as $o)
            <option value="{{ $o->id }}" {{(isset($current) && (string)$current === (string)$o->id)? 'selected' : ''}}>
                {{ $o->name }}
            </option>
        @endforeach
    </select>
</div>
