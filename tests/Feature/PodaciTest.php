<?php

namespace Tests\Feature;

use App\Models\Podatak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PodaciTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_podaci_page(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->get(route('podaci'));

        $response->assertOk();
        $response->assertSee('Osobni podaci');
    }

    public function test_authenticated_user_can_store_podatak(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->post(route('podaci.store'), [
            'label' => 'Broj police',
            'value' => 'ABC-123',
            'category' => 'ostalo',
        ]);

        $response->assertRedirect(route('podaci', absolute: false));

        $this->assertDatabaseHas('podaci', [
            'user_id' => $user->id,
            'label' => 'Broj police',
            'value' => 'ABC-123',
            'category' => 'ostalo',
        ]);
    }

    public function test_authenticated_user_can_update_podatak(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $podatak = Podatak::create([
            'user_id' => $user->id,
            'label' => 'Broj kartice',
            'value' => '4539-8421-7123-9084',
            'category' => 'kreditna-kartica',
        ]);

        $response = $this->actingAs($user)->put(route('podaci.update', $podatak), [
            'label' => 'Broj kartice',
            'value' => '1111222233334444',
            'category' => 'kreditna-kartica',
        ]);

        $response->assertRedirect(route('podaci', absolute: false));

        $this->assertDatabaseHas('podaci', [
            'id' => $podatak->id,
            'value' => '1111-2222-3333-4444',
        ]);
    }

    public function test_invalid_podatak_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->post(route('podaci.store'), [
            'label' => '',
            'value' => '',
            'category' => 'nepoznato',
        ]);

        $response->assertSessionHasErrors(['label', 'value', 'category']);
        $this->assertDatabaseCount('podaci', 0);
    }
}
