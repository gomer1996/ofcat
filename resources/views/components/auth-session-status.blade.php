@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }} style="margin: 15px">
        {{ $status }}
    </div>
@endif
