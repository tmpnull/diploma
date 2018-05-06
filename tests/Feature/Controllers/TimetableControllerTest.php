<?php

namespace Tests\Feature\Controllers;

use App\Audience;
use App\Group;
use App\Course;
use App\Timetable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TimetableControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var string */
    private $baseUrl = '/api/timetables/';

    /** @var Timetable */
    private $timetable;

    /** @var Group */
    private $group;

    public function setUp()
    {
        parent::setUp();
        /** @var Group $group */
        $this->group = factory(Group::class, 1)->create()->first();
        /** @var Audience $audience */
        $audience = factory(Audience::class, 1)->create()->first();
        /** @var Course $course */
        $course = factory(Course::class, 1)->create()->first();

        $this->timetable = new Timetable([
            'course_id' => $course->getAttribute('id'),
            'day_of_week' => 1,
            'number' => 1,
            'is_numerator' => $this->faker->boolean,
            'group_id' => $this->group->getAttribute('id'),
            'audience_id' => $audience->getAttribute('id'),
        ]);
        $response = $this->postJson($this->baseUrl, $this->timetable->toArray());
        $this->timetable->setAttribute('id', $response->json()['id']);
    }

    public function testInsertTimetable()
    {
        $this->assertDatabaseHas('timetables', ['course_id' => $this->timetable->getAttribute('course_id')]);
    }

    public function testListAllTimetables()
    {
        $response = $this->get($this->baseUrl);
        $response->assertJsonFragment(['course_id' => $this->timetable->getAttribute('course_id')]);
    }

    public function testListTimetableById()
    {
        $uri = $this->baseUrl.$this->timetable->getAttribute('id');
        $response = $this->get($uri);
        $response->assertJsonFragment(['course_id' => $this->timetable->getAttribute('course_id')]);
    }

    public function testUpdateTimetableById()
    {
        $uri = $this->baseUrl.$this->timetable->getAttribute('id');
        $number = 2;
        $response = $this->putJson($uri, ['number' => $number]);
        $response->assertJsonFragment(['number' => $number]);
    }

    public function testDeleteTimetableById()
    {
        $uri = $this->baseUrl.$this->timetable->getAttribute('id');
        $response = $this->deleteJson($uri);
        $response->assertSuccessful();
        $response->assertSee('1'); // Api should return 1 if entity was successfully deleted
    }

    /**
     * @return array
     */
    public function missedFieldsDataProvider(): array
    {
        return [
            'no course_id' => [
                new Timetable([
                    'day_of_week' => 1,
                    'number' => 1,
                    'is_numerator' => false,
                    'group_id' => 1,
                    'audience_id' => 1,
                ]),
                'course_id',
            ],
            'no day_of_week' => [
                new Timetable([
                    'course_id' => 1,
                    'number' => 1,
                    'is_numerator' => false,
                    'group_id' => 1,
                    'audience_id' => 1,
                ]),
                'day_of_week',
            ],
            'no number' => [
                new Timetable([
                    'course_id' => 1,
                    'day_of_week' => 1,
                    'is_numerator' => false,
                    'group_id' => 1,
                    'audience_id' => 1,
                ]),
                'number',
            ],
            'no is_numerator' => [
                new Timetable([
                    'course_id' => 1,
                    'day_of_week' => 1,
                    'number' => 1,
                    'group_id' => 1,
                    'audience_id' => 1,
                ]),
                'is_numerator',
            ],
            'no group_id' => [
                new Timetable([
                    'course_id' => 1,
                    'day_of_week' => 1,
                    'number' => 1,
                    'is_numerator' => false,
                    'audience_id' => 1,
                ]),
                'group_id',
            ],
            'no audience_id' => [
                new Timetable([
                    'course_id' => 1,
                    'day_of_week' => 1,
                    'number' => 1,
                    'is_numerator' => false,
                ]),
                'audience_id',
            ],
        ];
    }

    /**
     * @dataProvider missedFieldsDataProvider
     * @param Timetable $timetable
     */
    public function testInsertTimetableWithoutRequiredFields(Timetable $timetable, string $field)
    {
        $response = $this->postJson($this->baseUrl, $timetable->toArray());
        $response->assertJsonValidationErrors([$field]);
        $response->assertStatus(422);
    }

    public function testInsertTimetableWithRepeatedValue()
    {
        $this->postJson($this->baseUrl, $this->timetable->toArray());
        $response = $this->postJson($this->baseUrl, $this->timetable->toArray());
        $response->assertStatus(422);
    }

    public function testInsertTimetableWithWrongForeignKey()
    {
        $data = $this->timetable->toArray();
        $data['audience_id'] = 999999;
        $response = $this->postJson($this->baseUrl, $data);
        $response->assertStatus(422);
    }

    public function testInsertAfterDelete()
    {
        $this->delete($this->baseUrl.$this->timetable->getAttribute('id'));
        $response = $this->postJson($this->baseUrl, $this->timetable->toArray());
        $response->assertStatus(422);
    }

    public function testSelectByGroupId()
    {
        $this->setConfigurationString('start_of_semester', '2017-09-01');
        $uri = $this->baseUrl.'group/'.$this->group->getAttribute('id');
        $response = $this->get($uri);

        $response->assertStatus(200);
    }

    /**
     * @return array
     */
    public function timetableRequestParams(): array
    {
        return [
            'no period' => [
                'period' => null,
                'dividend' => 'denominator',
                'date' => '2017-09-03',
            ],
            'no dividend' => [
                'period' => 'day',
                'dividend' => null,
                'date' => '2017-09-03',
            ],
        ];
    }

    /**
     * @dataProvider timetableRequestParams
     * @param string period
     * @param string dividend
     * @param string date
     */
    public function testSelectByGroupIdQueryParams(string $period = null, string $dividend = null, string $date = null)
    {
        $this->setConfigurationString('start_of_semester', '2017-09-01');
        $uri = $this->baseUrl.'group/'.$this->group->getAttribute('id').'?date='.$date;
        if ($period) {
            $uri = $uri.'&period='.$period;
        }
        if ($dividend) {
            $uri = $uri.'&dividend='.$dividend;
        }
        $response = $this->get($uri);

        $response->assertStatus(200);
    }

    public function testSelectByGroupIdWrongForeignKey()
    {
        $this->setConfigurationString('start_of_semester', '2017-09-01');
        $uri = $this->baseUrl.'group/'. 999999;
        $response = $this->get($uri);

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }
}
