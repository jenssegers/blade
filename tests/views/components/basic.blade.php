@props(['id'])
<div id="{{ $id }}" {{ $attributes }}>
    {{ $slot }}
</div>
