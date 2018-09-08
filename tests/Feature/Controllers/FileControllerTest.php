<?php

namespace Tests\Feature\Controllers;

use App\File;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/files/';

    /** @var File */
    private $file;

    private $image;

    protected function setUp()
    {
        parent::setUp();

        $this->image = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->postJson($this->baseUrl, [
            'photo' => $this->image,
            'public' => false,
        ]);

        $this->file = new File($response->json());
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
            'no photo' => [
                [
                    'public' => false,
                ],
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param File $file
     */
    public function testInsertFileWithoutRequiredFields($file)
    {
        $response = $this->postJson($this->baseUrl, $file);
        $response->assertStatus(422);
    }
}
