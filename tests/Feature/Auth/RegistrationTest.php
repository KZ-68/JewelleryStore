<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function __construct()
    {
        Role::create(['guard_name' => 'web', 'name' => 'basic']);
    }

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_new_customers_can_register()
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('settings', absolute: false));
    }
}
