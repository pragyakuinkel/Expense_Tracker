@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-white text-start text-base font-medium text-white bg-[#0d94d2] hover:bg-[#0b83bb] focus:outline-none focus:bg-[#0b83bb] focus:border-white transition duration-150 ease-in-out'
                : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-white hover:bg-[#0d94d2] hover:border-[#0d94d2] focus:outline-none focus:text-white focus:bg-[#0d94d2] focus:border-[#0d94d2] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
