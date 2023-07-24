@props([
    'category' => null
])

@if($category)
<a href="{{ route('categories.show', $category) }}">
    <div class="mt-8 mb-8 flex">
        <div>
            <div class="flex items-center mr-12 h-16 border-l-4 border-gray-600">
            </div>
            <div class="flex items-center mr-12 h-16 border-l-4 border-gray-300">

            </div>
        </div>
        <div>
            <div class="flex items-center h-16">
                <span class="text-lg text-gray-600 font-bold">{{ $category->name }}</span>
            </div>
            <div class="flex items-center py-2">
                <span class="text-gray-500">{{ $category->description }}</span>

            </div>
        </div>
    </div>
</a>
@endif
