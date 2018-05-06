<?php

namespace Tests\Feature\Controllers;

use App\Teacher;
use App\Course;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CourseControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/courses/';

    /** @var Course */
    private $course;

    public function setUp()
    {
        parent::setUp();

        /** @var Teacher $teacher */
        $teacher = factory(Teacher::class, 1)->create()->first();

        $this->course = new Course([
            'name' => $this->faker->word,
            'teacher_id' => $teacher->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->course->toArray());
        $this->course->setAttribute('id', $response->json()['id']);
    }

    public function testInsertCourse()
    {
        $this->assertDatabaseHas('courses', ['name' => $this->course->getAttribute('name')]);
    }

    public function testListAllCourses()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['name' => $this->course->getAttribute('name')]);
    }

    public function testListCourseById()
    {
        $uri = $this->baseUrl.$this->course->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['name' => $this->course->getAttribute('name')]);
    }

    public function testUpdateCourseById()
    {
        $uri = $this->baseUrl.$this->course->getAttribute('id');
        $name = 'Changed name';
        $response = $this->putJson($uri, ['name' => $name]);
        $response->assertJsonFragment(['name' => $name]);
    }

    public function testDeleteCourseById()
    {
        $uri = $this->baseUrl.$this->course->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    public function missedFieldsDataProvider()
    {
        return [
            'no name' => [
                new Course([
                    'teacher_id' => 1,
                ]),
                'name',
            ],
            'no teacher_id' => [
                new Course([
                    'name' => 'testName',
                ]),
                'teacher_id',
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Course $teacher
     */
    public function testInsertCourseWithoutRequiredFields(Course $teacher, $field)
    {
        $response = $this->postJson($this->baseUrl, $teacher->toArray());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([$field]);
    }

    public function testInsertCourseWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->course->toArray());
        $response = $this->postJson($this->baseUrl, $this->course->toArray());
        $response->assertStatus(422);
    }
}
