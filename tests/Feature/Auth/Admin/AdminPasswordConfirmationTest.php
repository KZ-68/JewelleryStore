<?php

namespace Tests\Feature\Auth\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminPasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin-password.confirm'));

        $response->assertStatus(200);

        $response->assertInertia(fn (Assert $page) => $page
            ->component('auth/ConfirmPassword')
        );
    }

    public function test_password_confirmation_requires_authentication()
    {
        $response = $this->get(route('admin-password.confirm'));

        $response->assertRedirect(route('login'));
    }
}
