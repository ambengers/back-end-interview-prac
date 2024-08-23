<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_get_product_page(): void
    {
        $this->get(route('products.index'))
            ->assertStatus(200)
            ->assertViewIs('products');
    }

    public function test_can_store_product(): void
    {
        $this->post(
            route('products.store'), $input = [
                'name' => $this->faker->sentence(),
            ]
        )->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', $input);
    }

    public function test_can_store_product_with_unique_name(): void
    {
        $product = Product::create(['name' => 'First Product']);

        $this->post(route('products.store'), $input = [
                'name' => $product->name,
            ]
        )->assertRedirect(route('products.index'))
            ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
    }
}
