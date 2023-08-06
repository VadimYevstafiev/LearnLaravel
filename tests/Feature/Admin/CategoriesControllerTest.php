<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use Tests\TestCase;

class CategoriesControllerTest extends TestCase
{
    use AdminTestsFunctions;

    public function test_allow_see_categories_with_role_admin()
    {
        $categories = Category::orderByDesc('id')->paginate(5)->pluck('name')->toArray();
        $response = $this->actingAs($this->getUser())->get(route('admin.categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.categories.index');
        $response->assertSeeInOrder($categories);
    }

    public function test_do_not_allow_see_categories_with_role_customer()
    {
        $response = $this->actingAs($this->getUser('customer'))->get(route('admin.categories.index'));
        $response->assertStatus(403);
    }

    public function test_create_category_with_valid_data()
    {
        $categoryData = Category::factory()->withParent()->make()->toArray();
        
        $response = $this->actingAs($this->getUser())
            ->post(route('admin.categories.store'), $categoryData);

        $response->assertStatus(302);
        $response->assertRedirectToRoute('admin.categories.index');
        $this->assertDatabaseHas('categories', [
           'name' => $categoryData['name']
        ]);
    }


    public function test_create_category_with_invalid_data()
    {
        $categoryData = ['name' => 'a'];
        
        $response = $this->actingAs($this->getUser())
            ->post(route('admin.categories.store'), $categoryData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name']);
    }
}
