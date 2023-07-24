<x-app-layout>
<x-banner link="#" linkText="test"></x-banner>
    <div class="p-8">
        <div class="bg-white p-4 rounded-lg shadow-xl py-8 mt-12">
            <h4 class="text-2xl font-bold text-gray-800 tracking-widest uppercase text-center">
                Categories
            </h4>
            <div class="space-y-12 px-2 xl:px-16 mt-12">
                @foreach($categories as $category)
                    <x-category-grid :category="$category" />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>