<?php

namespace Tests\Feature\Controllers;

use App\Speciality;
use App\Department;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SpecialityControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string $baseUrl */
    private $baseUrl = '/api/specialities/';

    /** @var Speciality $speciality */
    private $speciality;

    protected function setUp()
    {
        parent::setUp();
        /** @var Department $department */
        $department = factory(Department::class, 1)->create()->first();

        $this->speciality = new Speciality([
            'name' => $this->faker->name(),
            'number' => $this->faker->numberBetween(1, 5),
            'department_id' => $department->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->speciality->toArray());
        $this->speciality->setAttribute('id', $response->json()['id']);
    }

    public function testInsertSpeciality()
    {
        $this->assertDatabaseHas('specialities', ['name' => $this->speciality->getAttribute('name')]);
    }

    public function testListAllSpecialities()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->speciality->getAttribute('name')]);
    }

    public function testListSpecialityById()
    {
        $uri = $this->baseUrl.$this->speciality->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->speciality->getAttribute('name')]);
    }

    public function testUpdateSpecialityById()
    {
        $uri = $this->baseUrl.$this->speciality->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteSpecialityById()
    {
        $uri = $this->baseUrl.$this->speciality->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Speciality([
                    'number' => 3,
                    'department_id' => 1,
                ]),
            ],
            'no number' => [
                new Speciality([
                    'name' => 'asdfasd',
                    'department_id' => 1,
                ]),
            ],
            'no speciality_id' => [
                new Speciality([
                    'name' => 'asdfasd',
                    'abbreviation' => 'asdfasdf',
                    'number' => 1,
                ]),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Speciality $speciality
     */
    public function testInsertSpecialityWithoutRequiredFields(Speciality $speciality)
    {
        $response = $this->postJson($this->baseUrl, $speciality->toArray());
        $response->assertStatus(422);
    }

    public function testInsertSpecialityWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->speciality->toArray());
        $response = $this->postJson($this->baseUrl, $this->speciality->toArray());
        $response->assertStatus(422);
    }

    public function testInsertSpecialityWithWrongForeignKey()
    {
        $data = $this->speciality->toArray();
        $data['speciality_id'] = 999999;
        $response = $this->postJson($this->baseUrl, $data);
        $response->assertStatus(422);
    }
}
