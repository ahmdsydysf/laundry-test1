@props(['key'])

@session ($key)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 dark:text-green-400']) }}>
        {{ $value }}
    </div>
@endsession
