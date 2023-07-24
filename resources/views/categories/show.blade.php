<x-app-layout>

<x-banner link="#" linkText="test"></x-banner>

<section class="bg-white py-8">

<div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3 ">
        <div class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl">
            {{ $category->name }}
        </div>
        @if (!empty($childs))
            <div class="w-full container mx-auto flex flex-wrap items-center justify-start mt-0 px-2 py-3">
                @foreach($childs as $child)
                    <a 
                        class="tracking-wide no-underline hover:no-underline text-gray-500 text-xl mr-3 border-solid border-2 border-gray-300 rounded-full px-4 py-1 inline-block"
                        href="{{ route('categories.show', $child) }}">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

        <div class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl">
            Products
        </div>
    </div>

    @foreach($products as $product)
        <x-product-grid :product="$product" />
    @endforeach
</div>
{{ $products->links() }}

</section>
</x-app-layout>