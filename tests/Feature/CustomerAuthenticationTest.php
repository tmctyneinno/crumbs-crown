<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CustomerAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_is_signed_in(): void
    {
        $this->get(route('register'))->assertOk()->assertSee('Create your account');

        $this->post(route('register.store'), [
            'name' => 'Morgan Customer',
            'email' => 'morgan@example.test',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ])->assertRedirect(route('shop'));

        $user = User::where('email', 'morgan@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertFalse($user->is_admin);
        $this->assertTrue(Hash::check('SecurePass123!', $user->password));
    }

    public function test_customer_can_sign_in_and_sign_out(): void
    {
        $user = User::factory()->create(['password' => 'SecurePass123!']);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'SecurePass123!',
        ])->assertRedirect(route('shop'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('account'))->assertOk()->assertSee($user->name);

        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_customer_can_request_and_complete_a_password_reset(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect()
            ->assertSessionHas('status');

        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use (&$token): bool {
            $token = $notification->token;

            return true;
        });

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee('Choose a new password');

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ])->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertTrue(Hash::check('NewSecurePass123!', $user->fresh()->password));
    }
}
