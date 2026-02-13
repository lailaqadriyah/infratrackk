<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Realisasi;
use Tests\TestCase;

class EditRealisasiPageTest extends TestCase
{
    public function test_edit_realisasi_page_loads()
    {
        $user = User::first();
        $realisasi = Realisasi::first();
        
        $response = $this->actingAs($user)
            ->get("/user/realisasi/{$realisasi->id}/edit");
        
        $response->assertStatus(200)
            ->assertViewIs('user.realisasi.edit')
            ->assertViewHas('realisasi')
            ->assertViewHas('opds')
            ->assertViewHas('tahuns');
    }
}
