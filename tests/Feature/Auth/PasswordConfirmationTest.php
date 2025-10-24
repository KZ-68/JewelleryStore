<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Customer;
use Spatie\Permission\Models\Role;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = Customer::factory()->create();
        $user->assignRole('basic');
        $response = $this->actingAs($user)->get(route('password.confirm'));

        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            ->component('auth/ConfirmPassword')
        );
    }

    public function test_password_confirmation_requires_authentication()
    {
        $response = $this->get(route('password.confirm'));

        $response->assertRedirect(route('login'));
    }
}
