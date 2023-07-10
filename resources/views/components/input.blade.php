@props(['type'])
@props(['name'])
@props(['label'])


<div class="row mb-3 align-items-center">
    <div class="col-1">
        <label  class="form-label">{{ $label ?? $slot }}</label>
    </div>
    <div class="col-auto">
        <input {{ $attributes->merge(['class'=>'form-control']) }} type="{{$type}}" name="{{$name}}" />
    </div>
</div>
