<?php

namespace Tests\Feature\Controllers;

use App\Position;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var string */
    private $baseUrl = '/api/users/';
    /** @var User */
    private $user;

    public function setUp()
    {
        parent::setUp();

        $position = factory(Position::class, 1)->create()->first();
        $role = factory(Role::class, 1)->create()->first();

        $this->user = new User([
            'name' => self::$faker->firstName(),
            'login' => self::$faker->firstName(),
            'surname' => self::$faker->lastName(),
            'patronymic' => self::$faker->firstName(),
            'date_of_birth' => self::$faker->date(),
            'email' => self::$faker->email(),
            'mobile_phone' => self::$faker->phoneNumber(),
            'work_phone' => self::$faker->phoneNumber(),
            'gender' => self::$faker->boolean(),
            'position_id' => $position->getAttribute('id'),
            'role_id' => $role->getAttribute('id'),
            'is_active' => true,
            'password' => self::$faker->password(),
        ]);
        $data = $this->user->toArray();
        $data['password'] = $this->user->getAttribute('password');
        $response = $this->postJson($this->baseUrl, $data);
        $this->user->setAttribute('id', $response->json()['id']);
    }

    public function testInsertUser()
    {
        $this->assertDatabaseHas('users', ['name' => $this->user->getAttribute('name')]);
    }

    public function testListAllUsers()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->user->getAttribute('name')]);
    }

    public function testListUserById()
    {
        $uri = $this->baseUrl . $this->user->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->user->getAttribute('name')]);
    }

    public function testUpdateUserById()
    {
        $uri = $this->baseUrl . $this->user->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteUserById()
    {
        $uri = $this->baseUrl . $this->user->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new User([
                    'surname' => 'asdfasdf',
                    'patronymic' => 'asdfadf',
                    'date_of_birth' => '1985-04-25',
                    'email' => 'asda@example.com',
                    'mobile_phone' => '123123-24324-234',
                    'work_phone' => '2342-4234-234',
                    'gender' => '0',
                    'is_active' => '1',
                    'password' => 'asdfasdf',
                    'login' => 'asda',
                ]),
                'name',
            ],
            'no surname' => [
                new User([
                    'name' => 'asdfasdf',
                    'email' => 'asda@example.com',
                    'patronymic' => 'asdfadf',
                    'date_of_birth' => '1985-04-25',
                    'mobile_phone' => '123123-24324-234',
                    'work_phone' => '2342-4234-234',
                    'gender' => '0',
                    'is_active' => '1',
                    'password' => 'asdfasdf',
                    'login' => 'asda',
                ]),
                'surname',
            ],
            'no patronymic' => [
                new User([
                    'name' => 'asdfasdf',
                    'email' => 'asda@example.com',
                    'surname' => 'asdfadf',
                    'date_of_birth' => '1985-04-25',
                    'mobile_phone' => '123123-24324-234',
                    'work_phone' => '2342-4234-234',
                    'gender' => '0',
                    'is_active' => '1',
                    'password' => 'asdfasdf',
                    'login' => 'asda',
                ]),
                'patronymic',
            ],
            'no login' => [
                new User([
                    'name' => 'asdfasdf',
                    'surname' => 'asdfasdf',
                    'patronymic' => 'asdfadf',
                    'email' => 'asda@example.com',
                    'date_of_birth' => '1985-04-25',
                    'mobile_phone' => '123123-24324-234',
                    'work_phone' => '2342-4234-234',
                    'gender' => '0',
                    'is_active' => '1',
                    'password' => 'asdfasdf',
                ]),
                'login',
            ],
            'no gender' => [
                new User([
                    'name' => 'asdfasdf',
                    'email' => 'asda@example.com',
                    'surname' => 'asdfadf',
                    'patronymic' => 'asdfadf',
                    'date_of_birth' => '1985-04-25',
                    'mobile_phone' => '123123-24324-234',
                    'work_phone' => '2342-4234-234',
                    'is_active' => '1',
                    'password' => 'asdfasdf',
                    'login' => 'asda',
                ]),
                'gender',
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param User $user
     */
    public function testInsertUserWithoutRequiredFields(User $user, string $field)
    {
        $response = $this->postJson($this->baseUrl, $user->toArray());
        $response->assertJsonValidationErrors([$field]);
        $response->assertStatus(422);
    }

    public function testInsertUserWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->user->toArray());
        $response = $this->postJson($this->baseUrl, $this->user->toArray());
        $response->assertStatus(422);
    }

    public function testInsertUserWithWrongForeignKey()
    {
        $data = $this->user->toArray();
        $data['building_id'] = 999999;
        $response = $this->postJson($this->baseUrl, $data);
        $response->assertStatus(422);
    }

    public function testInsertAfterDelete()
    {
        $this->delete($this->baseUrl . $this->user->getAttribute('id'));
        $response = $this->postJson($this->baseUrl, $this->user->toArray());
        $response->assertStatus(422);
    }
}
