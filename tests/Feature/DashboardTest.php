<?php

namespace Tests\Feature;

use App\Models\Dokument;
use App\Models\Isprava;
use App\Models\Podatak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_database_values_and_no_quick_actions(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        Podatak::create([
            'user_id' => $user->id,
            'category' => 'identitet',
            'label' => 'OIB',
            'value' => '12345678901',
        ]);

        Isprava::create([
            'user_id' => $user->id,
            'name' => 'Osobna iskaznica',
            'category' => 'identitet',
            'document_number' => '123456789',
            'expires_at' => now()->addYear(),
        ]);

        Dokument::create([
            'user_id' => $user->id,
            'name' => 'Ugovor o najmu',
            'category' => 'ugovori',
            'file_path' => '1/ugovor.pdf',
            'original_name' => 'Ugovor o najmu.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 1024,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Osnovni podaci');
        $response->assertSee('OIB');
        $response->assertSee('12345678901');
        $response->assertSee('Osobna iskaznica');
        $response->assertSee('Ugovor o najmu.pdf');
        $response->assertDontSee('Brze akcije');
        $response->assertDontSee('Dodaj novi sadržaj u nekoliko sekundi.');
    }
}
