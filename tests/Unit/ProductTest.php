<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = new Product();
    }

    public function test_it_belongs_to_many_tags(): void
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->product->tags());
    }
}
