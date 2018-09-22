<?php

namespace App\Services;

use App\Configuration;
use App\Course;
use App\Timetable;
use App\Http\Resources\Timetable as TimetableResource;
use App\QueryParameters\TimetableQueryParameters;
use Illuminate\Database\Eloquent\Collection;
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
     *
     * @return TimetableResource
     */
    public function show(int $id): TimetableResource
    {
        return TimetableResource::make(Timetable::find($id));
    }

    /**
     * @param int $id
     * @param TimetableQueryParameters $queryParameters
     *
     * @return TimetableResource
     */
    public function showByGroupId(int $id, TimetableQueryParameters $queryParameters): TimetableResource
    {
        $timetables = Timetable::where('group_id', $id)->get();
        $datesOfStartSemesters = $this->getDatesOfStartSemesters();

        if ($datesOfStartSemesters->count() < 2) {
            abort(403, 'One of start semester date is not present');
        }

        $timetables = $this->filterBySemester($timetables, $queryParameters, $datesOfStartSemesters);
        $timetables = $this->filterByDividend($timetables, $queryParameters, $datesOfStartSemesters);
        $timetables = $this->filterByDay($timetables, $queryParameters);

        return TimetableResource::make($timetables);
    }

    /**
     * @param int $id
     * @param TimetableQueryParameters $queryParameters
     *
     * @return TimetableResource
     */
    public function showByTeacherId(int $id, TimetableQueryParameters $queryParameters): TimetableResource
    {
        $courses = Course::where('teacher_id', $id)->get();
        $timetables = Timetable::whereIn('course_id', $courses)->get();
        $datesOfStartSemesters = $this->getDatesOfStartSemesters();

        if ($datesOfStartSemesters->count() < 2) {
            abort(403, 'One of start semester date is not present');
        }

        $timetables = $this->filterBySemester($timetables, $queryParameters, $datesOfStartSemesters);
        $timetables = $this->filterByDividend($timetables, $queryParameters, $datesOfStartSemesters);
        $timetables = $this->filterByDay($timetables, $queryParameters);

        return TimetableResource::make($timetables);
    }

    /**
     * @param array $data
     *
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
     *
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
     *
     * @return int
     */
    public function destroy(int $id): int
    {
        return Timetable::destroy($id);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $collection
     * @param TimetableQueryParameters $queryParameters
     * @param \Illuminate\Support\Collection $datesOfStartSemesters
     *
     * @return mixed
     */
    private function filterBySemester($collection, $queryParameters, $datesOfStartSemesters)
    {
        if ($queryParameters->getSemester()) {
            $semester = $queryParameters->getSemester();
            if ($semester === TimetableQueryParameters::$SEMESTER_AUTO) {
                if ($queryParameters->getDate()) {
                    $semester = $queryParameters->getDate()->between($datesOfStartSemesters->get(0), $datesOfStartSemesters->get(1)) ? 'first' : 'second';
                } else {
                    return $collection;
                }
            }

            $requested = $semester === TimetableQueryParameters::$SEMESTER_FIRST;

            $collection = $collection->filter(function (Timetable $timetable) use ($requested) {
                return (bool) $timetable->getAttribute('is_first_semester') === $requested;
            });
        }

        return $collection;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $collection
     * @param TimetableQueryParameters $queryParameters
     * @param \Illuminate\Support\Collection $datesOfStartSemesters
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function filterByDividend($collection, $queryParameters, $datesOfStartSemesters): Collection
    {
        if ($queryParameters->getDividend()) {
            $dividend = $queryParameters->getDividend();
            if ($dividend === TimetableQueryParameters::$DIVIDEND_AUTO || !$dividend) {
                $date = $queryParameters->getDate() ?: new Carbon();
                if ($date) {
                    $date->between($datesOfStartSemesters->get(0), $datesOfStartSemesters->get(1))
                        ? $weekOfSemesterStart = $datesOfStartSemesters->get(0)->weekOfYear
                        : $weekOfSemesterStart = $datesOfStartSemesters->get(1)->weekOfYear;
                    $weekNumber = $date->weekOfYear;
                    $dividend = $this->isNumerator($weekOfSemesterStart, $weekNumber)
                        ? TimetableQueryParameters::$DIVIDEND_NUMERATOR
                        : TimetableQueryParameters::$DIVIDEND_DENOMINATOR;
                }
            }

            $requested = $dividend === TimetableQueryParameters::$DIVIDEND_NUMERATOR;

            $collection = $collection->filter(function (Timetable $timetable) use ($requested) {
                return (bool) $timetable->getAttribute('is_numerator') === $requested
                    || $timetable->getAttribute('is_numerator') === null;
            });
        }

        return $collection;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $collection
     * @param TimetableQueryParameters $queryParameters
     *
     * @return mixed
     */
    private function filterByDay($collection, $queryParameters)
    {
        $day = $queryParameters->getDay();
        $date = $queryParameters->getDate();
        if ($day) {
            $collection = $collection->filter(function (Timetable $value, $key) use ($day) {
                return $value->getAttribute('day_of_week') === $day;
            });
        } elseif ($date) {
            $collection = $collection->filter(function (Timetable $value, $key) use ($date) {
                return $value->getAttribute('day_of_week') === $date->dayOfWeek;
            });
        }

        return $collection;
    }

    /**
     * This function provide us to determine if requested timetable is enum in current semester
     *
     * @param int $startOfSemester
     * @param int $weekNumber
     *
     * @return bool
     */
    private function isNumerator(int $startOfSemester, int $weekNumber): bool
    {
        $isFirstWeekEven = $startOfSemester % 2 === 0;
        $isSecondWeekEven = $weekNumber % 2 === 0;

        return $isFirstWeekEven === $isSecondWeekEven;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function getDatesOfStartSemesters(): \Illuminate\Support\Collection
    {
        /** @var \Illuminate\Database\Eloquent\Collection $datesOfStartSemesters */
        $datesOfStartSemesters = Configuration::whereIn('key', [
            'start_of_first_semester',
            'start_of_second_semester',
        ])->get()->map(function ($item) {
            return new Carbon($item->getAttribute('value'));
        });

        return $datesOfStartSemesters;
    }
}
