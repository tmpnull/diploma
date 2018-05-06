<?php

namespace Tests\Unit\Controllers;


use App\Services\TimetableService;
use Carbon\Carbon;
use Tests\TestCase;

class TimetableControllerTest extends TestCase
{
    public function checkNumeratorDataProvider()
    {
        return [
            'expected true 1' => [
                'timetable_numerator' => true,
                'start_of_semester' => '2017-09-01',
                'picked_date' => '2017-09-02',
                'expected' => true,
            ],
            'expected true 2' => [
                'timetable_numerator' => false,
                'start_of_semester' => '2017-09-01',
                'picked_date' => '2017-09-05',
                'expected' => true,
            ],
            'expected false 1' => [
                'timetable_numerator' => false,
                'start_of_semester' => '2017-09-01',
                'picked_date' => '2017-09-02',
                'expected' => false,
            ],
            'expected false 2' => [
                'timetable_numerator' => true,
                'start_of_semester' => '2017-09-01',
                'picked_date' => '2017-09-05',
                'expected' => false,
            ],
        ];
    }

    /**
     * @dataProvider checkNumeratorDataProvider
     * @param bool $timetable_numerator
     * @param string $start_of_semester
     * @param string $picked_date
     * @param bool $expected
     */
    public function testCheckNumeratorOfCourse(
        bool $timetable_numerator,
        string $start_of_semester,
        string $picked_date,
        bool $expected
    ) {
        /** @var TimetableService $timetableService */
        $timetableService = new TimetableService();
        $startOfSemester = new Carbon($start_of_semester);
        $currentDate = new Carbon($picked_date);

        $result = $this->invokeMethod(
            $timetableService,
            'isNumerator',
            [
                $timetable_numerator,
                $startOfSemester->weekOfYear,
                $currentDate->weekOfYear,
            ]
        );
        $this->assertEquals($expected, $result);
    }
}