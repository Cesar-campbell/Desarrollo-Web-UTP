<div class="space-y-6">
    
    <div>
        <x-input-label for="description" :value="__('Description')"/>
        <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $product?->description)" autocomplete="description" placeholder="Description"/>
        <x-input-error class="mt-2" :messages="$errors->get('description')"/>
    </div>
    <div>
        <x-input-label for="price" :value="__('Price')"/>
        <x-text-input id="price" name="price" type="text" class="mt-1 block w-full" :value="old('price', $product?->price)" autocomplete="price" placeholder="Price"/>
        <x-input-error class="mt-2" :messages="$errors->get('price')"/>
    </div>
    <div>
        <x-input-label for="stock" :value="__('Stock')"/>
        <x-text-input id="stock" name="stock" type="text" class="mt-1 block w-full" :value="old('stock', $product?->stock)" autocomplete="stock" placeholder="Stock"/>
        <x-input-error class="mt-2" :messages="$errors->get('stock')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>