<?php

namespace Tests\Feature;

use App\Models\Pengaju;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = Pengaju::create([
            'nik' => '747100000401',
            'nama_lengkap' => 'Profile User 1',
            'nim' => 'E1E120401',
            'jurusan' => 'Teknik Informatika',
            'email' => 'profile1@example.com',
            'email_verified_at' => now(),
            'no_hp' => '081234567831',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this
            ->actingAs($user, 'pengaju')
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = Pengaju::create([
            'nik' => '747100000402',
            'nama_lengkap' => 'Profile User 2',
            'nim' => 'E1E120402',
            'jurusan' => 'Teknik Informatika',
            'email' => 'profile2@example.com',
            'email_verified_at' => now(),
            'no_hp' => '081234567832',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this
            ->actingAs($user, 'pengaju')
            ->patch('/profile', [
                'nama_lengkap' => 'Test User',
                'jurusan' => 'Teknik Informatika',
                'no_hp' => '081234567890',
                'alamat' => 'Kendari',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->nama_lengkap);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = Pengaju::create([
            'nik' => '747100000403',
            'nama_lengkap' => 'Profile User 3',
            'nim' => 'E1E120403',
            'jurusan' => 'Teknik Informatika',
            'email' => 'profile3@example.com',
            'email_verified_at' => now(),
            'no_hp' => '081234567833',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this
            ->actingAs($user, 'pengaju')
            ->patch('/profile', [
                'nama_lengkap' => $user->nama_lengkap,
                'jurusan' => $user->jurusan,
                'no_hp' => $user->no_hp,
                'alamat' => $user->alamat,
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = Pengaju::create([
            'nik' => '747100000404',
            'nama_lengkap' => 'Profile User 4',
            'nim' => 'E1E120404',
            'jurusan' => 'Teknik Informatika',
            'email' => 'profile4@example.com',
            'email_verified_at' => now(),
            'no_hp' => '081234567834',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this
            ->actingAs($user, 'pengaju')
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest('pengaju');
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = Pengaju::create([
            'nik' => '747100000405',
            'nama_lengkap' => 'Profile User 5',
            'nim' => 'E1E120405',
            'jurusan' => 'Teknik Informatika',
            'email' => 'profile5@example.com',
            'email_verified_at' => now(),
            'no_hp' => '081234567835',
            'alamat' => 'Kendari',
            'password' => 'password',
        ]);

        $response = $this
            ->actingAs($user, 'pengaju')
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }
}
