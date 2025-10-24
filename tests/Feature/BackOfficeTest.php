<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BackOfficeTest extends TestCase
{
    use RefreshDatabase;

    public function __construct()
    {
        Role::create(['guard_name' => 'admin', 'name' => 'admin']);
    }

    public function test_guests_are_redirected_to_the_login_page()
    {
        $response = $this->get(route('admin.back-office.showBO'));
        $response->assertRedirect(route('admin-login'));
    }

    public function test_authenticated_users_can_visit_the_dashboard()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $response = $this->get(route('admin.back-office.showBO'));
        $response->assertStatus(200);
    }
}
