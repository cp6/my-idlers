<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <select class="form-control" name="{{$name}}">
        <option value="MB" {{(isset($value) && $value == 'MB')? 'selected': ''}}>MB</option>
        <option value="GB" {{(isset($value) && $value == 'GB')? 'selected': ''}}>GB</option>
    </select></div>
