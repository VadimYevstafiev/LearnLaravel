<?php

namespace App\Repositories;

use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryContract
{
    public function create(CreateProductRequest $request): Product|false
    {
        try {
            DB::beginTransaction();

            $data = $this->formatRequestData($request);
            $data['attributes'] = array_merge(
                $data['attributes'],
                [
                    'slug' => Str::of($data['attributes']['title'])->slug('-'),
                    'thumbnail' => 'https://via.placeholder.com/640x480.png/008811?text=ut'
                ]
            );
            $product = Product::create($data['attributes']);
            $this->setCategories($product, $data['categories']);

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            logs()->warning($e);
            return false;
        }
    }

    protected function formatRequestData(CreateProductRequest $request): array
    {
        return [
            'attributes' => collect($request->validated())->except(['categories'])->toArray(),
            'categories' => $request->get('categories', [])
        ];
    }

    protected function setCategories(Product $product, array $categories = [])
    {
        if (!empty($categories)) {
            $product->categories()->attach($categories);
        }
    }
}
