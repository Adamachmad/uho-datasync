<?php

namespace Tests\Feature\Auth;

use App\Models\Pengaju;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000001',
            'nama_lengkap' => 'Test Pengaju',
            'nim' => 'E1E120001',
            'jurusan' => 'Teknik Informatika',
            'email' => 'test-pengaju@example.com',
            'no_hp' => '081234567890',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('pengaju');
        $this->assertGuest('web');
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000002',
            'nama_lengkap' => 'Test Pengaju 2',
            'nim' => 'E1E120002',
            'jurusan' => 'Teknik Informatika',
            'email' => 'test-pengaju2@example.com',
            'no_hp' => '081234567891',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('pengaju');
    }

    public function test_users_can_logout(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000003',
            'nama_lengkap' => 'Test Pengaju 3',
            'nim' => 'E1E120003',
            'jurusan' => 'Teknik Informatika',
            'email' => 'test-pengaju3@example.com',
            'no_hp' => '081234567892',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user, 'pengaju')->post('/logout');

        $this->assertGuest('pengaju');
        $response->assertRedirect('/');
    }
}
