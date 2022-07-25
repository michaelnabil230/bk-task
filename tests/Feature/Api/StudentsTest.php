<?php

namespace Tests\Feature\Api;

use App\Models\Student;
use App\Models\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_students()
    {
        $school = School::factory()->create();

        Student::factory(20)->create(['school_id' => $school->id]);

        $response = $this->getJson('/api/schools/' . $school->id . '/students');

        $responseArray = json_decode($response->getContent());

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals(count($responseArray->students->data), 15);
    }

    public function test_new_students()
    {
        $school = School::factory()->create();

        $this
            ->postJson('/api/schools/' . $school->id . '/students', ['name' => 'Test student'])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('student.name', 'Test student');
    }

    public function test_edit_students()
    {
        $school = School::factory()->create();
        $student = Student::factory()->create(['school_id' => $school->id]);

        $this
            ->putJson('/api/schools/' . $school->id . '/students/' . $student->id, ['name' => 'Test student 2'])
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJsonPath('student.name', 'Test student 2');
    }

    public function test_delete_students()
    {
        $school = School::factory()->create();
        $student = Student::factory()->create(['school_id' => $school->id]);

        $this
            ->deleteJson('/api/schools/' . $school->id . '/students/' . $student->id)
            ->assertNoContent();

        $this
            ->getJson('/api/schools/' . $school->id . '/students/' . $student->id)
            ->assertNotFound();
    }
}
