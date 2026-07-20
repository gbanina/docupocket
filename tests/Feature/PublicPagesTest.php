<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_privacy_page_can_be_rendered(): void
    {
        $response = $this->get(route('privacy'));

        $response->assertOk();
        $response->assertSee('Koje podatke pohranjujemo');
        $response->assertSee('Legal');
    }

    public function test_legal_page_can_be_rendered(): void
    {
        $response = $this->get(route('legal'));

        $response->assertOk();
        $response->assertSee('Korištenje usluge');
        $response->assertSee('Privacy');
    }
}
