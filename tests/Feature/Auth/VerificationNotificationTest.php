<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Customer;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerificationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function __construct()
    {
        Role::create(['guard_name' => 'web', 'name' => 'basic']);
    }

    public function test_sends_verification_notification(): void
    {
        Notification::fake();

        $user = Customer::factory()->unverified()->create();
        $user->assignRole('basic');
        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('home'));

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_does_not_send_verification_notification_if_email_is_verified(): void
    {
        Notification::fake();

        $user = Customer::factory()->create();
        $user->assignRole('basic');
        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('settings', absolute: false));

        Notification::assertNothingSent();
    }
}
