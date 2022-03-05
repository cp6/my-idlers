<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <input type="number" name="{{$name}}" class="form-control" min="{{$min ?? 0}}" max="{{$max ?? 99999}}"
           step="{{$step ?? 1}}" value="{{$value ?? ''}}" {{(isset($required))? 'required': ''}}>
</div>
