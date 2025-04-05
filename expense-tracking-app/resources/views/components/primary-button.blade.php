<button
    {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-[#0ea5e9] focus:ring-offset-2 transition ease-in-out duration-150',
    'style' => 'background-color:#0ea5e9'
    ]) }}>
    {{ $slot }}
</button>
