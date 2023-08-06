<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    use AdminTestsFunctions;

    public function test_allow_see_products_with_role_admin()
    {
        $products = Product::orderByDesc('id')->paginate(5)->pluck('title')->toArray();
        $response = $this->actingAs($this->getUser())->get(route('admin.products.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
        $response->assertSeeInOrder($products);
    }

    public function test_do_not_allow_see_products_with_role_customer()
    {
        $response = $this->actingAs($this->getUser('customer'))->get(route('admin.products.index'));
        $response->assertStatus(403);
    }

    public function test_create_product_with_valid_data()
    {
        $productdata = Product::factory()->make()->toArray();
        $productdata['thumbnail'] = UploadedFile::fake()->create('test\path\image.png');

        $response = $this->actingAs($this->getUser())
            ->post(route('admin.products.store'), $productdata);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.products.index');
        // $this->assertDatabaseHas('products', [
        //    'title' => $productdata['title']
        // ]);
        $this->assertDatabaseHas( 'products', [
            'title'     => $productdata['title'],
            'SKU'       => $productdata['SKU'],
            'price'     => $productdata['price'],
            'quantity'  => $productdata['quantity'],
           // 'thumbnail' => $productdata['thumbnail']
        ] );
    }

    public function test_create_product_with_invalid_data()
    {
        $productdata = ['title' => 'a'];

        $response = $this->actingAs($this->getUser())
            ->post(route('admin.products.store'), $productdata);
            
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['title']);
    }
}
