<div>
    <p {{ $attributes->merge(['class'=>"text-lg font-semibold text-gray-700",'style'=>'color:grey']) }}>
        {{ $slot }}
    </p>
</div>
