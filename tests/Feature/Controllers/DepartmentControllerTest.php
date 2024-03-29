<?php

namespace Tests\Feature\Controllers;

use App\Department;
use App\Faculty;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/departments/';

    /** @var Department */
    private $department;

    protected function setUp()
    {
        parent::setUp();
        /** @var Faculty $faculty */
        $faculty = factory(Faculty::class, 1)->create()->first();

        $this->department = new Department([
            'name' => $this->faker->name(),
            'abbreviation' => $this->faker->shuffleString('МФРТСЛА'),
            'number' => $this->faker->numberBetween(1, 5),
            'faculty_id' => $faculty->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->department->toArray());
        $this->department->setAttribute('id', $response->json()['id']);
    }

    public function testInsertDepartment()
    {
        $this->assertDatabaseHas('departments', ['name' => $this->department->getAttribute('name')]);
    }

    public function testListAllDepartments()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->department->getAttribute('name')]);
    }

    public function testListDepartmentById()
    {
        $uri = $this->baseUrl.$this->department->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->department->getAttribute('name')]);
    }

    public function testUpdateDepartmentById()
    {
        $uri = $this->baseUrl.$this->department->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteDepartmentById()
    {
        $uri = $this->baseUrl.$this->department->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Department([
                    'number' => 3,
                    'abbreviation' => 'asdfasdf',
                    'faculty_id' => 1,
                ]),
            ],
            'no abbreviation' => [
                new Department([
                    'number' => 3,
                    'name' => 'asdfasdf',
                    'faculty_id' => 1,
                ]),
            ],
            'no number' => [
                new Department([
                    'name' => 'asdfasd',
                    'abbreviation' => 'asdfasdf',
                    'faculty_id' => 1,
                ]),
            ],
            'no faculty_id' => [
                new Department([
                    'name' => 'asdfasd',
                    'abbreviation' => 'asdfasdf',
                    'number' => 1,
                ]),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Department $department
     */
    public function testInsertDepartmentWithoutRequiredFields(Department $department)
    {
        $response = $this->postJson($this->baseUrl, $department->toArray());
        $response->assertStatus(422);
    }

    public function testInsertDepartmentWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->department->toArray());
        $response = $this->postJson($this->baseUrl, $this->department->toArray());
        $response->assertStatus(422);
    }

    public function testInsertDepartmentWithWrongForeignKey()
    {
        $data = $this->department->toArray();
        $data['faculty_id'] = 999999;
        $response = $this->postJson($this->baseUrl, $data);
        $response->assertStatus(422);
    }
}
