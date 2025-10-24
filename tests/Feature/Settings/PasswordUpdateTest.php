<?php

namespace Tests\Feature\Settings;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function __construct()
    {
        Role::create(['guard_name' => 'admin', 'name' => 'admin']);
    }

    public function test_password_update_page_is_displayed()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $response = $this
            ->actingAs($user)
            ->get(route('password.edit'));

        $response->assertStatus(200);
    }

    public function test_password_can_be_updated()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $response = $this
            ->actingAs($user)
            ->from(route('password.edit'))
            ->put(route('password.update'), [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('password.edit'));

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $response = $this
            ->actingAs($user)
            ->from(route('password.edit'))
            ->put(route('password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrors('current_password')
            ->assertRedirect(route('password.edit'));
    }
}
