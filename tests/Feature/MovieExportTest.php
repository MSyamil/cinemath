<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_excel_returns_success_and_correct_headers(): void
    {
        // Act as a guest first
        $response = $this->get(route('movies.export-excel', [
            'comparison_value' => 5,
            'genre' => null,
            'watched_filter' => 'all'
        ]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.ms-excel');
        $response->assertHeader('Content-Disposition', 'attachment; filename="CineMatch_AHP_SAW_Recommendations.xls"');

        // Check if AHP/SAW details are present in the response
        $content = $response->streamedContent();
        $this->assertStringContainsString('CINEMATCH MOVIE RECOMMENDATION REPORT', $content);
        $this->assertStringContainsString('ANALYTIC HIERARCHY PROCESS', $content);
        $this->assertStringContainsString('SIMPLE ADDITIVE WEIGHTING', $content);
        $this->assertStringContainsString('Critics Quality', $content);
        $this->assertStringContainsString('Global Hype', $content);
    }

    public function test_export_excel_with_authorized_user_and_different_values(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('movies.export-excel', [
            'comparison_value' => 8,
            'genre' => 28, // Action
            'watched_filter' => 'unwatched'
        ]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.ms-excel');

        $content = $response->streamedContent();
        $this->assertStringContainsString('Action', $content);
        $this->assertStringContainsString('Belum Ditonton', $content);
        $this->assertStringContainsString('Lebih condong ke Global Hype', $content);
    }
}
