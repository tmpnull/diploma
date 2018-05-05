<?php

namespace Tests\Feature\Controllers;

use App\Faculty;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacultyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var string */
    private $baseUrl = '/api/faculties/';
    /** @var Faculty */
    private $faculty;

    public function setUp()
    {
        parent::setUp();
        $this->faculty = new Faculty([
            'name' => self::$faker->name(),
            'abbreviation' => self::$faker->shuffleString('МФРТСЛА'),
            'number' => self::$faker->numberBetween(1, 5)
        ]);
        $response = $this->postJson($this->baseUrl, $this->faculty->toArray());
        $this->faculty->setAttribute('id', $response->json()['id']);
    }

    public function testInsertFaculty()
    {
        $this->assertDatabaseHas('faculties', ['name' => $this->faculty->getAttribute('name')]);
    }

    public function testListAllFaculties()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->faculty->getAttribute('name')]);
    }

    public function testListFacultyById()
    {
        $uri = $this->baseUrl . $this->faculty->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->faculty->getAttribute('name')]);
    }

    public function testUpdateFacultyById()
    {
        $uri = $this->baseUrl . $this->faculty->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteFacultyById()
    {
        $uri = $this->baseUrl . $this->faculty->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Faculty([
                    'number' => 3,
                    'abbreviation' => 'asdfasdf',
                ])
            ],
            'no abbreviation' => [
                new Faculty([
                    'number' => 3,
                    'name' => 'asdfasdf',
                ])
            ],
            'no number' => [
                new Faculty([
                    'name' => 'asdfasd',
                    'abbreviation' => 'asdfasdf',
                ])
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Faculty $faculty
     */
    public function testInsertFacultyWithoutRequiredFields(Faculty $faculty)
    {
        $response = $this->postJson($this->baseUrl, $faculty->toArray());
        $response->assertStatus(422);
    }

    public function testInsertFacultyWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->faculty->toArray());
        $response = $this->postJson($this->baseUrl, $this->faculty->toArray());
        $response->assertStatus(422);
    }
}
