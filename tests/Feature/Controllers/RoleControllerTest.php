<?php

namespace Tests\Feature\Controllers;

use App\Role;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/roles/';

    /** @var Role */
    private $role;

    protected function setUp()
    {
        parent::setUp();
        $this->role = new Role([
            'name' => $this->faker->jobTitle(),
        ]);
        $response = $this->postJson($this->baseUrl, $this->role->toArray());
        $this->role->setAttribute('id', $response->json()['id']);
    }

    public function testInsertRole()
    {
        $this->assertDatabaseHas('roles', ['name' => $this->role->getAttribute('name')]);
    }

    public function testListAllRoles()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->role->getAttribute('name')]);
    }

    public function testListRoleById()
    {
        $uri = $this->baseUrl.$this->role->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->role->getAttribute('name')]);
    }

    public function testUpdateRoleById()
    {
        $uri = $this->baseUrl.$this->role->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteRoleById()
    {
        $uri = $this->baseUrl.$this->role->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Role(),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Role $role
     */
    public function testInsertRoleWithoutRequiredFields(Role $role)
    {
        $response = $this->postJson($this->baseUrl, $role->toArray());
        $response->assertStatus(422);
    }

    public function testInsertRoleWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->role->toArray());
        $response = $this->postJson($this->baseUrl, $this->role->toArray());
        $response->assertStatus(422);
    }
}
