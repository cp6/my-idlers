<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <select class="form-control" name="{{$name}}">
        <option value=""></option>
        @foreach ($labels as $label)
            <option value="{{ $label['id'] }}" {{(isset($current) && $current == $label['id'])? 'selected' : ''}}>
                {{ $label['label']}}
            </option>
        @endforeach
    </select>
</div>
