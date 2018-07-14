<?php

namespace Tests\Feature\Controllers;

use App\Position;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PositionControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/positions/';

    /** @var Position */
    private $position;

    protected function setUp()
    {
        parent::setUp();
        $this->position = new Position([
            'name' => $this->faker->jobTitle(),
        ]);
        $response = $this->postJson($this->baseUrl, $this->position->toArray());
        $this->position->setAttribute('id', $response->json()['id']);
    }

    public function testInsertPosition()
    {
        $this->assertDatabaseHas('positions', ['name' => $this->position->getAttribute('name')]);
    }

    public function testListAllPositions()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->position->getAttribute('name')]);
    }

    public function testListPositionById()
    {
        $uri = $this->baseUrl.$this->position->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->position->getAttribute('name')]);
    }

    public function testUpdatePositionById()
    {
        $uri = $this->baseUrl.$this->position->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeletePositionById()
    {
        $uri = $this->baseUrl.$this->position->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Position(),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Position $position
     */
    public function testInsertPositionWithoutRequiredFields(Position $position)
    {
        $response = $this->postJson($this->baseUrl, $position->toArray());
        $response->assertStatus(422);
    }

    public function testInsertPositionWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->position->toArray());
        $response = $this->postJson($this->baseUrl, $this->position->toArray());
        $response->assertStatus(422);
    }
}
