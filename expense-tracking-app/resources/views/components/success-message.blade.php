<div>
    <div {{ $attributes->merge([
        'style' => 'border: 2px solid #28a745;
                    background-color: #d4edda;
                    color: #155724;
                    padding: 12px;
                    border-radius: 12px;
                    font-weight: bold;
                    font-family: Arial, sans-serif;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    transition: transform 0.3s ease;
                    margin-bottom: 16px;
                    ']) }}>
        {{ $slot }}
    </div>
</div>

