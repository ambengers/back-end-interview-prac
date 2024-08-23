<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Tag;
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

    public function test_can_get_products_page(): void
    {
        $this->get(route('products.index'))
            ->assertStatus(200)
            ->assertViewIs('products');
    }

    public function test_can_store_a_product_with_description(): void
    {
        $this->post(
            route('products.store'), $input = [
                'name' => $this->faker->sentence(),
                'description' => $this->faker->paragraph(),
            ]
        )->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', $input);
    }

    public function test_can_store_a_product_with_unique_name(): void
    {
        $product = Product::create(['name' => 'First Product']);

        $this->post(route('products.store'), $input = [
                'name' => $product->name,
            ]
        )->assertRedirect(route('products.index'))
            ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
    }

    public function test_can_store_a_product_with_tags_separated_by_comma(): void
    {
        $this->post(route('products.store'), $input = [
                'name' => $this->faker->sentence(),
                'tags' => 'Tag1, Tag2, Tag3',
            ]
        );

        $tagsInput = explode(',', $input['tags']);

        collect($tagsInput)->each(function ($tag) {
            $this->assertDatabaseHas('tags', ['name' => trim($tag)]);
        });

        $product = Product::first();
        $tags = Tag::whereIn('id', $tagsInput)->get();

        $tags->each(function ($tag) use ($product) {
            $this->assertDatabaseHas('product_tag', [
                'product_id' => $product->id,
                'tag_id' => $tag->id
            ]);
        });
    }

    public function test_can_delete_a_product(): void
    {
        $product = Product::create(['name' => 'First Product']);

        $this->assertDatabaseHas('products', $product->only('id', 'name'));

        $this->delete(route('products.destroy', ['id' => $product->id]))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', $product->only('id', 'name'));
    }
}



















