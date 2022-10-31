<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{$title}}</span></div>
    <input type="text" name="{{$name}}" class="form-control" minlength="{{$min ?? 0}}" maxlength="{{$max ?? 99999}}"
           value="{{$value ?? ''}}" @if(isset($placeholder)) placeholder="{{$placeholder}}" @endif {{(isset($required))? 'required': ''}}>
    @error((string)$name)<span class="text-red-500">{{ $message }}</span>@enderror
</div>
