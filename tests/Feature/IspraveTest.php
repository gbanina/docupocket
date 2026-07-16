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

    public function test_authenticated_user_can_view_isprave_index_page_with_database_values(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $frontImage = UploadedFile::fake()->image('front.jpg');
        $frontPath = $frontImage->store('isprave', 'public');

        Isprava::create([
            'user_id' => $user->id,
            'name' => 'Osobna iskaznica',
            'category' => 'identitet',
            'document_number' => '123456789',
            'expires_at' => now()->addYear(),
            'note' => 'Test napomena',
            'front_image_path' => $frontPath,
        ]);

        $response = $this->actingAs($user)->get(route('isprave'));

        $response->assertOk();
        $response->assertSee('Osobna iskaznica');
        $response->assertSee('123456789');
        $response->assertSee('Test napomena');
    }

    public function test_authenticated_user_can_view_isprava_show_page(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $frontImage = UploadedFile::fake()->image('front.jpg');
        $frontPath = $frontImage->store('isprave', 'public');

        $isprava = Isprava::create([
            'user_id' => $user->id,
            'name' => 'Osobna iskaznica',
            'category' => 'identitet',
            'document_number' => '123456789',
            'issuer' => 'MUP',
            'issued_at' => now()->subYear(),
            'expires_at' => now()->addYear(),
            'reminder_enabled' => true,
            'reminder_days' => 60,
            'note' => 'Test napomena',
            'front_image_path' => $frontPath,
        ]);

        $response = $this->actingAs($user)->get(route('isprave.show', $isprava));

        $response->assertOk();
        $response->assertSee('Detalji isprave');
        $response->assertSee('Osobna iskaznica');
        $response->assertSee('123456789');
        $response->assertSee('MUP');
    }

    public function test_authenticated_user_can_view_isprava_edit_page(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $isprava = Isprava::create([
            'user_id' => $user->id,
            'name' => 'Vozačka dozvola',
            'category' => 'vozilo',
            'document_number' => 'HR-2026-817265',
            'issuer' => 'MUP',
            'issued_at' => now()->subYear(),
            'expires_at' => now()->addYear(),
            'reminder_enabled' => true,
            'reminder_days' => 90,
            'note' => 'Test napomena',
        ]);

        $response = $this->actingAs($user)->get(route('isprave.edit', $isprava));

        $response->assertOk();
        $response->assertSee('Uredi ispravu');
        $response->assertSee('Vozačka dozvola');
        $response->assertSee('HR-2026-817265');
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

    public function test_authenticated_user_can_update_isprava(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $isprava = Isprava::create([
            'user_id' => $user->id,
            'name' => 'Stara isprava',
            'category' => 'ostalo',
            'note' => 'Stara napomena',
        ]);

        $frontImage = UploadedFile::fake()->image('new-front.jpg');

        $response = $this->actingAs($user)->put(route('isprave.update', $isprava), [
            'name' => 'Nova isprava',
            'category' => 'identitet',
            'document_number' => '123456789',
            'issuer' => 'MUP',
            'issued_at' => now()->subYear()->format('Y-m-d'),
            'expires_at' => now()->addYear()->format('Y-m-d'),
            'reminder_enabled' => 1,
            'reminder_days' => 45,
            'note' => 'Nova napomena',
            'front_image' => $frontImage,
        ]);

        $response->assertRedirect(route('isprave.show', $isprava, absolute: false));

        $isprava->refresh();

        $this->assertSame('Nova isprava', $isprava->name);
        $this->assertSame('identitet', $isprava->category);
        $this->assertSame('123456789', $isprava->document_number);
        $this->assertSame('MUP', $isprava->issuer);
        $this->assertSame('Nova napomena', $isprava->note);
        $this->assertTrue($isprava->reminder_enabled);
        $this->assertSame(45, $isprava->reminder_days);
        Storage::disk('public')->assertExists($isprava->front_image_path);
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
