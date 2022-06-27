<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{ $title ??'Currency'}}</span></div>
    <select class="form-control" name="{{$name ?? 'currency'}}">
        @foreach (App\Models\Pricing::getCurrencyList() as $currency)
            <option value="{{$currency}}" {{(isset($current) && (string)$current === $currency)? 'selected' : ''}}>
                {{$currency}}
            </option>
        @endforeach
    </select>
</div>
