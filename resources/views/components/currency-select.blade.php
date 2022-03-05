<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{ $title ??'Currency'}}</span></div>
    <select class="form-control" name="{{$name ?? 'currency'}}">
        <option value="AUD" {{(isset($current) && (string)$current === 'AUD')? 'selected' : ''}}>AUD</option>
        <option value="USD" {{(isset($current) && (string)$current === 'USD')? 'selected' : ''}}>USD</option>
        <option value="GBP" {{(isset($current) && (string)$current === 'GBP')? 'selected' : ''}}>GBP</option>
        <option value="EUR" {{(isset($current) && (string)$current === 'EUR')? 'selected' : ''}}>EUR</option>
        <option value="NZD" {{(isset($current) && (string)$current === 'NZD')? 'selected' : ''}}>NZD</option>
        <option value="JPY" {{(isset($current) && (string)$current === 'JPY')? 'selected' : ''}}>JPY</option>
        <option value="CAD" {{(isset($current) && (string)$current === 'CAD')? 'selected' : ''}}>CAD</option>
    </select>
</div>
