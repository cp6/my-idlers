<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <select class="form-control" name="{{$name}}">
        <option value="1" {{(isset($value) && $value == '1')? 'selected': ''}}>Yes</option>
        <option value="0" {{(isset($value) && $value == '0')? 'selected': ''}}>No</option>
    </select></div>
