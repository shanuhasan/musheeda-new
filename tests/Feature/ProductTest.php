<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $role = Role::create(['name' => 'Super Admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    public function test_admin_can_create_product()
    {
        $response = $this->actingAs($this->admin)->post('/admin/products', [
            'name' => 'ERP System',
            'slug' => 'erp-system',
            'status' => 'active',
            'price' => 5000.00,
            'features' => ['Inventory', 'Accounting'],
            'pricing_type' => 'subscription'
        ]);

        $response->assertRedirect('/admin/products');
        
        $this->assertDatabaseHas('products', [
            'name' => 'ERP System',
            'price' => 5000.00,
            'pricing_type' => 'subscription'
        ]);
        
        $product = Product::first();
        $this->assertEquals(['Inventory', 'Accounting'], $product->features);
    }

    public function test_public_can_view_active_products()
    {
        $product = Product::factory()->create(['status' => 'active']);
        
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee($product->name);

        $response = $this->get('/products/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_public_can_view_discontinued_products()
    {
        $product = Product::factory()->create(['status' => 'discontinued']);
        
        $response = $this->get('/products');
        $response->assertStatus(200);
        $response->assertSee($product->name);

        $response = $this->get('/products/' . $product->slug);
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_public_cannot_view_inactive_products()
    {
        $product = Product::factory()->create(['status' => 'inactive']);
        
        $response = $this->get('/products/' . $product->slug);
        $response->assertStatus(404);
    }
}
