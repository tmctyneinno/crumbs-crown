<?php

namespace Tests\Feature;

use App\Models\ContactEnquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEnquiryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_retrieve_connect_form_details(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        ContactEnquiry::create([
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '08012345678',
            'enquiry_type' => 'order',
            'message' => 'I need a celebration cake for Saturday.',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.enquiries.index'))
            ->assertOk()
            ->assertSee('Jane Doe')
            ->assertSee('jane@example.com')
            ->assertSee('08012345678')
            ->assertSee('Order')
            ->assertSee('I need a celebration cake for Saturday.')
            ->assertSee('x-on:toast.window', false);
    }

    public function test_enquiry_inbox_requires_admin_access(): void
    {
        $this->get(route('admin.enquiries.index'))
            ->assertRedirect(route('admin.login'));

        $this->actingAs(User::factory()->create())
            ->get(route('admin.enquiries.index'))
            ->assertForbidden();
    }

    public function test_redirect_flash_messages_are_shown_by_the_global_toast(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)
            ->withSession(['status' => 'Product changes saved.'])
            ->get(route('admin.enquiries.index'))
            ->assertOk()
            ->assertSee('Product changes saved.');
    }
}