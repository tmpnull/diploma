<?php

namespace Tests\Feature\Controllers;

use App\Audience;
use App\Building;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AudienceControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/audiences/';

    /** @var Audience */
    private $audience;

    public function setUp()
    {
        parent::setUp();
        /** @var Building $building */
        $building = factory(Building::class, 1)->create()->first();

        $this->audience = new Audience([
            'name' => $this->faker->name(),
            'abbreviation' => $this->faker->shuffleString('МФРТСЛА'),
            'number' => $this->faker->numberBetween(1, 5),
            'building_id' => $building->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->audience->toArray());
        $this->audience->setAttribute('id', $response->json()['id']);
    }

    public function testInsertAudience()
    {
        $this->assertDatabaseHas('audiences', ['name' => $this->audience->getAttribute('name')]);
    }

    public function testListAllAudiences()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->audience->getAttribute('name')]);
    }

    public function testListAudienceById()
    {
        $uri = $this->baseUrl.$this->audience->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->audience->getAttribute('name')]);
    }

    public function testUpdateAudienceById()
    {
        $uri = $this->baseUrl.$this->audience->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteAudienceById()
    {
        $uri = $this->baseUrl.$this->audience->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Audience([
                    'building_id' => 1,
                ]),
            ],
            'no building_id' => [
                new Audience([
                    'name' => 'asdfasd',
                ]),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Audience $audience
     */
    public function testInsertAudienceWithoutRequiredFields(Audience $audience)
    {
        $response = $this->postJson($this->baseUrl, $audience->toArray());
        $response->assertStatus(422);
    }

    public function testInsertAudienceWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->audience->toArray());
        $response = $this->postJson($this->baseUrl, $this->audience->toArray());
        $response->assertStatus(422);
    }

    public function testInsertAudienceWithWrongForeignKey()
    {
        $data = $this->audience->toArray();
        $data['building_id'] = 999999;
        $response = $this->postJson($this->baseUrl, $data);
        $response->assertStatus(422);
    }
}
