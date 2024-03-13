@props(['key'])

@error($key)
    <span  {!! $attributes->merge(['class' => 'text-danger my-2 d-block']) !!}>{{ $message }}</span>
@enderror
