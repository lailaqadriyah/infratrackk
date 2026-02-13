<?php

// Test file untuk verifikasi edit page
// Run: php test_edit_page.php

require_once 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create HTTP test request
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EditPageTest extends TestCase
{
    public function test_edit_page_loads()
    {
        // Create and authenticate a user
        $user = \App\Models\User::first();
        $realisasi = \App\Models\Realisasi::first();
        
        if (!$user || !$realisasi) {
            echo "No user or realisasi found\n";
            return;
        }
        
        $response = $this->actingAs($user)
            ->get("/user/realisasi/{$realisasi->id}/edit");
        
        $response->assertStatus(200);
        echo "✓ Edit page loaded successfully\n";
        echo "Route: /user/realisasi/{$realisasi->id}/edit\n";
    }
}

// Run test
$test = new EditPageTest();
$test->setUp();
try {
    $test->test_edit_page_loads();
    echo "Test passed!\n";
} catch (Exception $e) {
    echo "Test failed: " . $e->getMessage() . "\n";
}
?>
