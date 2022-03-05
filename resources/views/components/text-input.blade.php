<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <input type="text" name="{{$name}}" class="form-control" minlength="{{$min ?? 0}}" maxlength="{{$max ?? 99999}}"
           value="{{$value ?? ''}}" {{(isset($required))? 'required': ''}}>
</div>
