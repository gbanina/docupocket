<?php

namespace Tests\Feature;

use App\Models\Dokument;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DokumentiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_dokumenti_pages(): void
    {
        Storage::fake('local');

        $user = User::factory()->create(['email_verified_at' => now()]);

        $file = UploadedFile::fake()->create('primjer.pdf', 128, 'application/pdf');
        $path = $file->store($user->id, 'local');

        Dokument::create([
            'user_id' => $user->id,
            'name' => 'Primjer dokumenta',
            'category' => 'putovanje',
            'file_path' => $path,
            'original_name' => 'primjer.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 128 * 1024,
        ]);

        $this->actingAs($user)->get(route('dokumenti'))->assertOk()->assertSee('primjer.pdf');
        $this->actingAs($user)->get(route('dokumenti.create'))->assertOk()->assertSee('Dodaj dokument');
    }

    public function test_authenticated_user_can_store_dokument(): void
    {
        Storage::fake('local');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $file = UploadedFile::fake()->create('polica.pdf', 256, 'application/pdf');

        $response = $this->actingAs($user)->post(route('dokumenti.store'), [
            'name' => 'Polica putnog osiguranja',
            'category' => 'putovanje',
            'file' => $file,
        ]);

        $response->assertRedirect(route('dokumenti', absolute: false));

        $document = Dokument::query()->firstOrFail();

        $this->assertDatabaseHas('dokumenti', [
            'user_id' => $user->id,
            'name' => 'Polica putnog osiguranja',
            'category' => 'putovanje',
            'original_name' => 'polica.pdf',
        ]);

        Storage::disk('local')->assertExists($document->file_path);
        $this->assertStringStartsWith($user->id . '/', $document->file_path);
    }

    public function test_authenticated_user_can_update_dokument(): void
    {
        Storage::fake('local');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $initialFile = UploadedFile::fake()->create('staro.pdf', 128, 'application/pdf');
        $initialPath = $initialFile->store($user->id, 'local');

        $document = Dokument::create([
            'user_id' => $user->id,
            'name' => 'Stari naziv',
            'category' => 'ostalo',
            'file_path' => $initialPath,
            'original_name' => 'staro.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 128 * 1024,
        ]);

        Storage::disk('local')->assertExists($initialPath);

        $newFile = UploadedFile::fake()->create('novo.pdf', 512, 'application/pdf');

        $response = $this->actingAs($user)->put(route('dokumenti.update', $document), [
            'name' => 'Novi naziv',
            'category' => 'ugovori',
            'file' => $newFile,
        ]);

        $response->assertRedirect(route('dokumenti', absolute: false));

        $document->refresh();

        $this->assertSame('Novi naziv', $document->name);
        $this->assertSame('ugovori', $document->category);
        $this->assertSame('novo.pdf', $document->original_name);
        Storage::disk('local')->assertMissing($initialPath);
        Storage::disk('local')->assertExists($document->file_path);
    }

    public function test_authenticated_user_can_delete_dokument(): void
    {
        Storage::fake('local');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $file = UploadedFile::fake()->create('obrisi.pdf', 256, 'application/pdf');
        $path = $file->store($user->id, 'local');

        $document = Dokument::create([
            'user_id' => $user->id,
            'name' => 'Za brisanje',
            'category' => 'ostalo',
            'file_path' => $path,
            'original_name' => 'obrisi.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 256 * 1024,
        ]);

        $response = $this->actingAs($user)->delete(route('dokumenti.destroy', $document));

        $response->assertRedirect(route('dokumenti', absolute: false));

        $this->assertDatabaseCount('dokumenti', 0);
        Storage::disk('local')->assertMissing($path);
    }

    public function test_authenticated_user_can_preview_dokument(): void
    {
        Storage::fake('local');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $path = $user->id . '/preview.pdf';
        Storage::disk('local')->put($path, 'preview content');

        $document = Dokument::create([
            'user_id' => $user->id,
            'name' => 'Za pregled',
            'category' => 'ostalo',
            'file_path' => $path,
            'original_name' => 'preview.pdf',
            'mime_type' => 'application/pdf',
            'file_size' => 15,
        ]);

        $response = $this->actingAs($user)->get(route('dokumenti.preview', $document));

        $response->assertOk();
        $response->assertSee('preview content', false);
    }

    public function test_invalid_dokument_is_rejected(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $response = $this->actingAs($user)->post(route('dokumenti.store'), [
            'name' => '',
            'category' => 'nepoznato',
        ]);

        $response->assertSessionHasErrors(['name', 'category', 'file']);
        $this->assertDatabaseCount('dokumenti', 0);
    }
}
