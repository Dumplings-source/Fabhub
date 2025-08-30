@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-primary-light text-sm font-medium leading-5 text-primary-light focus:outline-none focus:border-primary-light transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-secondary-light hover:text-primary-light hover:border-primary-light/50 focus:outline-none focus:text-primary-light focus:border-primary-light/50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
