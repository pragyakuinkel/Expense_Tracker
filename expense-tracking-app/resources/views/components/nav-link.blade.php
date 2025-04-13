@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-4 py-2 text-sm font-semibold text-[#0ea5e9] bg-white rounded-md shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 transition duration-150 ease-in-out'
                : 'inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-transparent rounded-md hover:bg-[#0d94d2] focus:outline-none focus:bg-[#0d94d2] focus:ring-2 focus:ring-white focus:ring-opacity-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
