<?php

namespace App\Services;

use App\Configuration;
use App\Course;
use App\Timetable;
use App\Http\Resources\Timetable as TimetableResource;
use App\QueryParameters\TimetableQueryParameters;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class TimetableService
{
    /**
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return TimetableResource::collection(Timetable::all());
    }

    /**
     * @param int $id
     * @return TimetableResource
     */
    public function show(int $id): TimetableResource
    {
        return TimetableResource::make(Timetable::find($id));
    }

    /**
     * @param int $id
     * @param TimetableQueryParameters $queryParameters
     * @return TimetableResource
     */
    public function showByGroupId(int $id, TimetableQueryParameters $queryParameters): TimetableResource
    {
        $timetables = Timetable::where('group_id', $id)->get();

        if ($queryParameters->getDividend()) {
            if ($queryParameters->getDividend() === TimetableQueryParameters::$DIVIDEND_AUTO) {
                $startOfSemester = new Carbon(
                    Configuration::where('key', 'start_of_semester')->first()->getAttribute('value')
                );
                $weekOfSemesterStart = $startOfSemester->weekOfYear;
                $weekNumber = $queryParameters->getDate()->weekOfYear;
                $dividend = $this->isNumerator($weekOfSemesterStart, $weekNumber)
                    ? TimetableQueryParameters::$DIVIDEND_NUMERATOR
                    : TimetableQueryParameters::$DIVIDEND_DENOMINATOR;

                $timetables = $this->filterByDividend($timetables, $dividend);
            } else {
                $timetables = $this->filterByDividend($timetables, $queryParameters->getDividend());
            }
        }

        if ($queryParameters->getPeriod() === TimetableQueryParameters::$PERIOD_DAY) {
            if ($queryParameters->getDividend() === TimetableQueryParameters::$DIVIDEND_AUTO) {
                $timetables = $this->filterByDay($timetables, $queryParameters->getDate()->dayOfWeek);
            } else {
                $timetables = $this->filterByDay($timetables, $queryParameters->getDay());
            }
        }

        return TimetableResource::make($timetables);
    }

    /**
     * @param int $id
     * @param TimetableQueryParameters $queryParameters
     * @return TimetableResource
     */
    public function showByTeacherId(int $id, TimetableQueryParameters $queryParameters): TimetableResource
    {
        $courses = Course::where('teacher_id', $id)->get();
        $timetables = Timetable::whereIn('course_id', $courses)->get();

        if ($queryParameters->getDividend()) {
            if ($queryParameters->getDividend() === TimetableQueryParameters::$DIVIDEND_AUTO) {
                $startOfSemester = new Carbon(
                    Configuration::where('key', 'start_of_semester')->first()->getAttribute('value')
                );
                $weekOfSemesterStart = $startOfSemester->weekOfYear;
                $weekNumber = $queryParameters->getDate()->weekOfYear;
                $dividend = $this->isNumerator($weekOfSemesterStart, $weekNumber)
                    ? TimetableQueryParameters::$DIVIDEND_NUMERATOR
                    : TimetableQueryParameters::$DIVIDEND_DENOMINATOR;

                $timetables = $this->filterByDividend($timetables, $dividend);
            } else {
                $timetables = $this->filterByDividend($timetables, $queryParameters->getDividend());
            }
        }

        if ($queryParameters->getPeriod() === TimetableQueryParameters::$PERIOD_DAY) {
            if ($queryParameters->getDividend() === TimetableQueryParameters::$DIVIDEND_AUTO) {
                $timetables = $this->filterByDay($timetables, $queryParameters->getDate()->dayOfWeek);
            } else {
                $timetables = $this->filterByDay($timetables, $queryParameters->getDay());
            }
        }

        return TimetableResource::make($timetables);
    }

    /**
     * @param array $data
     * @return TimetableResource
     */
    public function store(array $data): TimetableResource
    {
        $timetable = new Timetable($data);
        $timetable->save();

        return TimetableResource::make($timetable);
    }

    /**
     * @param int $id
     * @param array $data
     * @return TimetableResource
     */
    public function update(int $id, array $data): TimetableResource
    {
        /** @var Timetable $timetable */
        $timetable = Timetable::find($id);
        $timetable->update($data);

        return TimetableResource::make($timetable);
    }

    /**
     * @param int $id
     * @return int
     */
    public function destroy(int $id): int
    {
        return Timetable::destroy($id);
    }

    /**
     * This function provide us to determine if requested timetable is enum in current semester
     *
     * @param int $startOfSemester
     * @param int $weekNumber
     * @return bool
     */
    private function isNumerator(int $startOfSemester, int $weekNumber): bool
    {
        $isFirstWeekEven = $startOfSemester % 2 === 0;
        $isSecondWeekEven = $weekNumber % 2 === 0;

        return $isFirstWeekEven === $isSecondWeekEven;
    }

    private function filterByDividend($collection, $dividend)
    {
        $requested = $dividend === TimetableQueryParameters::$DIVIDEND_NUMERATOR;

        $collection = $collection->filter(function (Timetable $value, $key) use ($requested) {
            return (bool) $value->getAttribute('is_numerator') === $requested;
        })->values();

        return $collection;
    }

    private function filterByDay($collection, $day)
    {
        $collection = $collection->filter(function (Timetable $value, $key) use ($day) {
            return $value->getAttribute('day_of_week') === $day;
        })->values();

        return $collection;
    }
}