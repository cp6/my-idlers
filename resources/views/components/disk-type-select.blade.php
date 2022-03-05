<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <select class="form-control" name="{{$name}}">
        <option value="GB" {{(isset($value) && $value == 'GB')? 'selected': ''}}>GB</option>
        <option value="TB" {{(isset($value) && $value == 'TB')? 'selected': ''}}>TB</option>
    </select></div>
