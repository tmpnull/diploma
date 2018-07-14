<?php

namespace Tests\Feature\Controllers;

use App\File;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/files/';

    /** @var File */
    private $file;

    protected function setUp()
    {
        parent::setUp();
        /** @var User $user */
        $user = factory(User::class, 1)->create()->first();
        $this->file = new File([
            'name' => $this->faker->word(),
            'user_id' => $user->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->file->toArray());
        $this->file->setAttribute('id', $response->json()['id']);
    }

    public function testInsertFile()
    {
        $this->assertDatabaseHas('files', ['name' => $this->file->getAttribute('name')]);
    }

    public function testListAllFiles()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->file->getAttribute('name')]);
    }

    public function testListFileById()
    {
        $uri = $this->baseUrl.$this->file->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->file->getAttribute('name')]);
    }

    public function testUpdateFileById()
    {
        $uri = $this->baseUrl.$this->file->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteFileById()
    {
        $uri = $this->baseUrl.$this->file->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new File([
                    'user_id' => 1,
                ]),
            ],
            'no user_id' => [
                new File([
                    'name' => 'asdasd',
                ]),
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param File $file
     */
    public function testInsertFileWithoutRequiredFields(File $file)
    {
        $response = $this->postJson($this->baseUrl, $file->toArray());
        $response->assertStatus(422);
    }

    public function testInsertFileWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->file->toArray());
        $response = $this->postJson($this->baseUrl, $this->file->toArray());
        $response->assertStatus(422);
    }
}
