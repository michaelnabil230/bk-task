<?php

namespace Tests\Feature\Api;

use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class SchoolsTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_schools()
    {
        School::factory(20)->create();

        $response = $this->getJson('/api/schools');

        $responseArray = json_decode($response->getContent());

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(count($responseArray->schools->data), 15);
    }

    public function test_new_schools()
    {
        $this
            ->postJson('/api/schools', ['name' => 'Test schools'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('school.name', 'Test schools');
    }

    public function test_edit_schools()
    {
        $school = School::factory()->create();

        $this
            ->putJson('/api/schools/' . $school->id, ['name' => 'Test school'])
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJsonPath('school.name', 'Test school');
    }

    public function test_delete_schools()
    {
        $school = School::factory()->create();

        $this
            ->deleteJson('/api/schools/' . $school->id)
            ->assertNoContent();

        $this
            ->getJson('/api/schools/' . $school->id)
            ->assertNotFound();
    }
}
