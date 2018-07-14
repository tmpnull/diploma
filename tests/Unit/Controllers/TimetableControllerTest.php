<?php

namespace Tests\Unit\Controllers;


use App\Services\TimetableService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TimetableControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function checkNumeratorDataProvider()
    {
        return [
            'expected true 1' => [
                'start_of_semester' => '2017-09-01',
                'picked_date' => '2017-09-02',
                'expected' => true,
            ],
            'expected false 2' => [
                'start_of_semester' => '2017-09-01',
                'picked_date' => '2017-09-05',
                'expected' => false,
            ],
        ];
    }

    /**
     * @dataProvider checkNumeratorDataProvider
     * @param string $start_of_semester
     * @param string $picked_date
     * @param bool $expected
     * @throws \ReflectionException
     */
    public function testIsNumerator(string $start_of_semester, string $picked_date, bool $expected
    ) {
        /** @var TimetableService $timetableService */
        $timetableService = new TimetableService();
        $startOfSemester = new Carbon($start_of_semester);
        $currentDate = new Carbon($picked_date);

        $result = $this->invokeMethod(
            $timetableService,
            'isNumerator',
            [
                $startOfSemester->weekOfYear,
                $currentDate->weekOfYear,
            ]
        );
        $this->assertEquals($expected, $result);
    }
}
