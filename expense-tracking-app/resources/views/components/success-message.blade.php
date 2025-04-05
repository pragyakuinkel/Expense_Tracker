<div>
    <div {{ $attributes->merge(['class' => 'border-2 border-green-500 bg-green-100 text-green-800 px-5 py-4 rounded-xl font-semibold font-sans shadow-md hover:shadow-lg transform transition-all duration-300 ease-in-out mb-6']) }}>
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-600"></i>
            {{ $slot }}
        </div>
    </div>
</div>
