<?php

namespace Tests\Feature\Controllers;

use App\Group;
use App\Student;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StudentControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/students/';

    /** @var Student */
    private $teacher;

    protected function setUp()
    {
        parent::setUp();
        /** @var User $user */
        $user = factory(User::class, 1)->create()->first();
        /** @var Group $group */
        $group = factory(Group::class, 1)->create()->first();

        $this->teacher = new Student([
            'user_id' => $user->getAttribute('id'),
            'group_id' => $group->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->teacher->toArray());
        $this->teacher->setAttribute('id', $response->json()['id']);
    }

    public function testInsertStudent()
    {
        $this->assertDatabaseHas('students', ['user_id' => $this->teacher->getAttribute('user_id')]);
    }

    public function testListAllStudents()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['user_id' => $this->teacher->getAttribute('user_id')]);
    }

    public function testListStudentById()
    {
        $uri = $this->baseUrl.$this->teacher->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['user_id' => $this->teacher->getAttribute('user_id')]);
    }

    public function testUpdateStudentById()
    {
        /** @var User $user */
        $user = factory(User::class, 1)->create()->first();
        $uri = $this->baseUrl.$this->teacher->getAttribute('id');
        $response = $this->putJson($uri, ['user_id' => $user->getAttribute('id')]);
        $response->assertJsonFragment(['user_id' => $user->getAttribute('id')]);
    }

    public function testDeleteStudentById()
    {
        $uri = $this->baseUrl.$this->teacher->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no user_id' => [
                new Student([
                    'group_id' => 1,
                ]),
            ],
            'no group_id' => [
                new Student([
                    'user_id' => 1,
                ]),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Student $teacher
     */
    public function testInsertStudentWithoutRequiredFields(Student $teacher)
    {
        $response = $this->postJson($this->baseUrl, $teacher->toArray());
        $response->assertStatus(422);
    }

    public function testInsertStudentWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->teacher->toArray());
        $response = $this->postJson($this->baseUrl, $this->teacher->toArray());
        $response->assertStatus(422);
    }
}
