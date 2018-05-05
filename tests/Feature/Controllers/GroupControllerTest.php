<?php

namespace Tests\Feature\Controllers;

use App\Group;
use App\Department;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var string */
    private $baseUrl = '/api/groups/';
    /** @var Group */
    private $group;

    public function setUp()
    {
        parent::setUp();
        /** @var Department $faculty */
        $department= factory(Department::class, 1)->create()->first();

        $this->group = new Group([
            'name' => self::$faker->shuffleString('234фыв'),
            'department_id' => $department->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->group->toArray());
        $this->group->setAttribute('id', $response->json()['id']);
    }

    public function testInsertGroup()
    {
        $this->assertDatabaseHas('groups', ['name' => $this->group->getAttribute('name')]);
    }

    public function testListAllGroups()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->group->getAttribute('name')]);
    }

    public function testListGroupById()
    {
        $uri = $this->baseUrl . $this->group->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->group->getAttribute('name')]);
    }

    public function testUpdateGroupById()
    {
        $uri = $this->baseUrl . $this->group->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteGroupById()
    {
        $uri = $this->baseUrl . $this->group->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Group([
                    'number' => 3,
                    'abbreviation' => 'asdfasdf',
                    'department_id' => 1,
                ])
            ],
            'no abbreviation' => [
                new Group([
                    'number' => 3,
                    'name' => 'asdfasdf',
                    'department_id' => 1,
                ])
            ],
            'no number' => [
                new Group([
                    'name' => 'asdfasd',
                    'abbreviation' => 'asdfasdf',
                    'department_id' => 1,
                ])
            ],
            'no department_id' => [
                new Group([
                    'name' => 'asdfasd',
                    'abbreviation' => 'asdfasdf',
                    'number' => 1,
                ])
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Group $group
     */
    public function testInsertGroupWithoutRequiredFields(Group $group)
    {
        $response = $this->postJson($this->baseUrl, $group->toArray());
        $response->assertStatus(422);
    }

    public function testInsertGroupWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->group->toArray());
        $response = $this->postJson($this->baseUrl, $this->group->toArray());
        $response->assertStatus(422);
    }

    public function testInsertDepartmentWithWrongForeignKey()
    {
        $data = $this->group->toArray();
        $data['department_id'] = 999999;
        $response = $this->postJson($this->baseUrl, $data);
        $response->assertStatus(422);
    }
}
