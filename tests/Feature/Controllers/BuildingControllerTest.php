<?php

namespace Tests\Feature\Controllers;

use App\Building;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BuildingControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/buildings/';

    /** @var Building */
    private $building;

    public function setUp()
    {
        parent::setUp();
        $this->building = new Building([
            'name' => $this->faker->name(),
            'abbreviation' => $this->faker->shuffleString('МФРТСЛА'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->building->toArray());
        $this->building->setAttribute('id', $response->json()['id']);
    }

    public function testInsertBuilding()
    {
        $this->assertDatabaseHas('buildings', ['name' => $this->building->getAttribute('name')]);
    }

    public function testListAllBuildings()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->building->getAttribute('name')]);
    }

    public function testListBuildingById()
    {
        $uri = $this->baseUrl.$this->building->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->building->getAttribute('name')]);
    }

    public function testUpdateBuildingById()
    {
        $uri = $this->baseUrl.$this->building->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteBuildingById()
    {
        $uri = $this->baseUrl.$this->building->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Building([
                    'abbreviation' => 'asdfasdf',
                ]),
            ],
            'no abbreviation' => [
                new Building([
                    'name' => 'asdfasdf',
                ]),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Building $building
     */
    public function testInsertBuildingWithoutRequiredFields(Building $building)
    {
        $response = $this->postJson($this->baseUrl, $building->toArray());
        $response->assertStatus(422);
    }

    public function testInsertBuildingWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->building->toArray());
        $response = $this->postJson($this->baseUrl, $this->building->toArray());
        $response->assertStatus(422);
    }
}
