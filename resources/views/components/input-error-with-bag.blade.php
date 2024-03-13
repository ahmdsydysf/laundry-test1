@props([
    'bagName' => null,
    'key' => null,
])

@if($errors?->$bagName?->has($key))
    <span class="my-1 d-block text-danger"> {{ $errors->$bagName->first($key) }} </span>
@endif
