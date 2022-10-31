<div class="form-check mb-2">
    <input class="form-check-input" name="{{$name}}" id="{{$id ?? 'formCheck'}}" type="checkbox"
           value="1" @if(isset($checked) && $checked === '1') checked @endif>
    <label class="form-check-label">
        {{$text}}
    </label>
</div>
