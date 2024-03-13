<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary d-grid w-100']) }}>
    {{ $slot }}
</button>
<style>
    .btn.btn-primary{
        background: #696cff;
    }
</style>
