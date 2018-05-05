<?php

namespace Tests\Feature\Controllers;

use App\Degree;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DegreeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var string */
    private $baseUrl = '/api/degrees/';
    /** @var Degree */
    private $degree;

    public function setUp()
    {
        parent::setUp();
        $this->degree = new Degree([
            'name' => self::$faker->jobTitle(),
        ]);
        $response = $this->postJson($this->baseUrl, $this->degree->toArray());
        $this->degree->setAttribute('id', $response->json()['id']);
    }

    public function testInsertDegree()
    {
        $this->assertDatabaseHas('degrees', ['name' => $this->degree->getAttribute('name')]);
    }

    public function testListAllDegrees()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->degree->getAttribute('name')]);
    }

    public function testListDegreeById()
    {
        $uri = $this->baseUrl . $this->degree->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->degree->getAttribute('name')]);
    }

    public function testUpdateDegreeById()
    {
        $uri = $this->baseUrl . $this->degree->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteDegreeById()
    {
        $uri = $this->baseUrl . $this->degree->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Degree()
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Degree $degree
     */
    public function testInsertDegreeWithoutRequiredFields(Degree $degree)
    {
        $response = $this->postJson($this->baseUrl, $degree->toArray());
        $response->assertStatus(422);
    }

    public function testInsertDegreeWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->degree->toArray());
        $response = $this->postJson($this->baseUrl, $this->degree->toArray());
        $response->assertStatus(422);
    }
}
