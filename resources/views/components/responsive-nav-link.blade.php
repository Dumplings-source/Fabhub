@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-primary-light text-left text-base font-medium text-primary-light bg-primary/10 focus:outline-none focus:text-primary-light focus:bg-primary/20 focus:border-primary-light transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-secondary-light hover:text-primary-light hover:bg-primary/5 hover:border-primary-light/50 focus:outline-none focus:text-primary-light focus:bg-primary/5 focus:border-primary-light/50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
