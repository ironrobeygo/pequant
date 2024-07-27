<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pequant-blue-600 border border-transparent rounded-lg active:pequant-blue-600 hover:pequant-blue-700 focus:outline-none']) }}>
    {{ $slot }}
</button>
