<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DokumentiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_dokumenti_page(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->get(route('dokumenti'));

        $response->assertOk();
        $response->assertSee('Dokumenti');
    }
}
