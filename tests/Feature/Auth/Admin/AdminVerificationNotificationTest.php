<?php

namespace Tests\Feature\Auth\Admin;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminVerificationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sends_verification_notification(): void
    {
        Notification::fake();
        Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $user = User::factory()->unverified()->create();
        $user->assignRole('admin');

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('home'));

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_does_not_send_verification_notification_if_email_is_verified(): void
    {
        Notification::fake();
        Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('admin-back-office.showBO', absolute: false));

        Notification::assertNothingSent();
    }
}
