<div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text">{{ $title ??'Term'}}</span></div>
    <select class="form-control" name="{{$name ?? 'payment_term'}}">
        <option value="1" {{(isset($current) && (string)$current === '1')? 'selected' : ''}}>Monthly</option>
        <option value="2" {{(isset($current) && (string)$current === '2')? 'selected' : ''}}>Quarterly</option>
        <option value="3" {{(isset($current) && (string)$current === '3')? 'selected' : ''}}>Half annual (half year)</option>
        <option value="4" {{(isset($current) && (string)$current === '4')? 'selected' : ''}}>Annual (yearly)</option>
        <option value="5" {{(isset($current) && (string)$current === '5')? 'selected' : ''}}>Biennial (2 years)</option>
        <option value="6" {{(isset($current) && (string)$current === '6')? 'selected' : ''}}>Triennial (3 years)</option>
    </select>
</div>
