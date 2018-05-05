<?php

namespace Tests\Feature\Controllers;

use App\Department;
use App\Teacher;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var string */
    private $baseUrl = '/api/teachers/';
    /** @var Teacher */
    private $teacher;

    public function setUp()
    {
        parent::setUp();
        /** @var User $user */
        $user = factory(User::class, 1)->create()->first();
        /** @var Department $department */
        $department = factory(Department::class, 1)->create()->first();

        $this->teacher = new Teacher([
            'user_id' => $user->getAttribute('id'),
            'department_id' => $department->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->teacher->toArray());
        $this->teacher->setAttribute('id', $response->json()['id']);
    }

    public function testInsertTeacher()
    {
        $this->assertDatabaseHas('teachers', ['user_id' => $this->teacher->getAttribute('user_id')]);
    }

    public function testListAllTeachers()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['user_id' => $this->teacher->getAttribute('user_id')]);
    }

    public function testListTeacherById()
    {
        $uri = $this->baseUrl . $this->teacher->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['user_id' => $this->teacher->getAttribute('user_id')]);
    }

    public function testUpdateTeacherById()
    {
        /** @var User $user */
        $user = factory(User::class, 1)->create()->first();
        $uri = $this->baseUrl . $this->teacher->getAttribute('id');
        $response = $this->putJson($uri, ['user_id' => $user->getAttribute('id')]);
        $response->assertJsonFragment(['user_id' => $user->getAttribute('id')]);
    }

    public function testDeleteTeacherById()
    {
        $uri = $this->baseUrl . $this->teacher->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no user_id' => [
                new Teacher([
                    'department_id' => 1,
                ])
            ],
            'no department_id' => [
                new Teacher([
                    'user_id' => 1,
                ])
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Teacher $teacher
     */
    public function testInsertTeacherWithoutRequiredFields(Teacher $teacher)
    {
        $response = $this->postJson($this->baseUrl, $teacher->toArray());
        $response->assertStatus(422);
    }

    public function testInsertTeacherWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->teacher->toArray());
        $response = $this->postJson($this->baseUrl, $this->teacher->toArray());
        $response->assertStatus(422);
    }
}
