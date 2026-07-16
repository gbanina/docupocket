<?php

namespace Tests\Feature;

use App\Models\Isprava;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class IspraveTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_isprave_create_page(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->get(route('isprave.create'));

        $response->assertOk();
        $response->assertSee('Dodaj ispravu');
    }

    public function test_authenticated_user_can_store_isprava(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $frontImage = UploadedFile::fake()->image('front.jpg');
        $backImage = UploadedFile::fake()->image('back.jpg');

        $response = $this->actingAs($user)->post(route('isprave.store'), [
            'name' => 'Osobna iskaznica',
            'category' => 'identitet',
            'note' => 'Test napomena',
            'front_image' => $frontImage,
            'back_image' => $backImage,
        ]);

        $response->assertRedirect(route('isprave', absolute: false));

        $this->assertDatabaseHas('isprave', [
            'user_id' => $user->id,
            'name' => 'Osobna iskaznica',
            'category' => 'identitet',
            'note' => 'Test napomena',
        ]);

        $isprava = Isprava::query()->firstOrFail();

        Storage::disk('public')->assertExists($isprava->front_image_path);
        Storage::disk('public')->assertExists($isprava->back_image_path);
    }

    public function test_invalid_isprava_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->post(route('isprave.store'), [
            'name' => '',
            'category' => 'nepoznato',
        ]);

        $response->assertSessionHasErrors(['name', 'category']);
        $this->assertDatabaseCount('isprave', 0);
    }
}
