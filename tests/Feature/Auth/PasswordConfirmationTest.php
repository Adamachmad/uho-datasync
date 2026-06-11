<?php

namespace Tests\Feature\Auth;

use App\Models\Pengaju;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000201',
            'nama_lengkap' => 'Confirm 1',
            'nim' => 'E1E120201',
            'jurusan' => 'Teknik Informatika',
            'email' => 'confirm1@example.com',
            'no_hp' => '081234567811',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user, 'pengaju')->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_confirmed(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000202',
            'nama_lengkap' => 'Confirm 2',
            'nim' => 'E1E120202',
            'jurusan' => 'Teknik Informatika',
            'email' => 'confirm2@example.com',
            'no_hp' => '081234567812',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user, 'pengaju')->post('/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = Pengaju::query()->create([
            'nik' => '747100000203',
            'nama_lengkap' => 'Confirm 3',
            'nim' => 'E1E120203',
            'jurusan' => 'Teknik Informatika',
            'email' => 'confirm3@example.com',
            'no_hp' => '081234567813',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this->actingAs($user, 'pengaju')->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
