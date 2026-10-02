<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_area_requires_an_admin_account(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));

        $this->actingAs(User::factory()->create())
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_can_sign_in_and_view_the_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Products in catalog');
    }

    public function test_admin_product_changes_flow_through_to_the_shop(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Celebration Cake',
                'description' => 'A cake added from the admin.',
                'price' => 42000,
                'rating' => 4.5,
                'category' => 'Celebration Cakes',
                'occasion' => 'Birthday',
                'dietary' => 'Eggless, gluten-free',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::firstOrFail();
        $this->assertSame('celebration-cakes', $product->category);
        $this->assertSame(['eggless', 'gluten-free'], $product->dietary);
        $this->get('/shop')->assertOk()->assertSee('Celebration Cake');

        $this->put(route('admin.products.update', $product), [
            'name' => 'Updated Celebration Cake',
            'description' => 'Updated from the admin.',
            'price' => 45000,
            'rating' => 5,
            'category' => 'Celebration Cakes',
            'occasion' => 'Birthday',
            'dietary' => '',
            'is_active' => '1',
        ])->assertRedirect(route('admin.products.index'));

        $this->get('/shop')
            ->assertSee('Updated Celebration Cake')
            ->assertDontSee('Celebration Cake</h3>');
    }
}
