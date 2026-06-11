<?php

namespace Tests\Feature\Auth;

use App\Models\Pengaju;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000101',
            'nama_lengkap' => 'Verifier 1',
            'nim' => 'E1E120101',
            'jurusan' => 'Teknik Informatika',
            'email' => 'verifier1@example.com',
            'no_hp' => '081234567801',
            'alamat' => 'Kendari',
            'password' => 'password',
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user, 'pengaju')->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000102',
            'nama_lengkap' => 'Verifier 2',
            'nim' => 'E1E120102',
            'jurusan' => 'Teknik Informatika',
            'email' => 'verifier2@example.com',
            'no_hp' => '081234567802',
            'alamat' => 'Kendari',
            'password' => 'password',
            'email_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user, 'pengaju')->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000103',
            'nama_lengkap' => 'Verifier 3',
            'nim' => 'E1E120103',
            'jurusan' => 'Teknik Informatika',
            'email' => 'verifier3@example.com',
            'no_hp' => '081234567803',
            'alamat' => 'Kendari',
            'password' => 'password',
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user, 'pengaju')->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
