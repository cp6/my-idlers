<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <input type="date" name="{{$name}}" class="form-control"
           value="{{$value ?? ''}}" {{(isset($required))? 'required': ''}}>
</div>
