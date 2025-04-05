@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-sky-500 focus:ring-sky-500 hover:border-sky-200 rounded-md shadow-sm w-full transition-colors duration-200']) }}>
