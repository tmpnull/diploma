<?php

namespace App\Services;

use App\Configuration;
use App\Timetable;
use App\Http\Resources\Timetable as TimetableResource;
use App\QueryParameters\TimetableQueryParameters;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

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
        $timetable = Timetable::where('group_id', $id)->get();
        $startOfSemester = new Carbon(Configuration::where('key', 'start_of_semester')->first()->getAttribute('value'));
        $weekOfSemesterStart = $startOfSemester->weekOfYear;
        $weekNumber = $queryParameters->getDate()->weekOfYear;
        if ($queryParameters->getFilterBy()) {
            $timetable = $timetable->filter(
                function (Timetable $value, $key) use ($weekOfSemesterStart, $weekNumber) {
                    return $this->isNumerator($value->getAttribute('is_numerator'), $weekOfSemesterStart, $weekNumber);
                }
            )->values();
        }


        return TimetableResource::make($timetable);
    }

    /**
     * @param int $id
     * @param TimetableQueryParameters $queryParameters
     * @return TimetableResource
     */
    public function showByTeacherId(int $id, TimetableQueryParameters $queryParameters): TimetableResource
    {
        $timetable = Timetable::where('group_id', $id)->get();
        $startOfSemester = new Carbon(Configuration::where('key', 'start_of_semester')->first()->getAttribute('value'));
        $weekOfSemesterStart = $startOfSemester->weekOfYear;
        $weekNumber = $queryParameters->getDate()->weekOfYear;

        $filtered = $timetable->filter(
            function (Timetable $value, $key) use ($weekOfSemesterStart, $weekNumber) {
                return $this->isNumerator($value->getAttribute('is_numerator'), $weekOfSemesterStart, $weekNumber);
            }
        )->values();

        return TimetableResource::make($filtered);
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
     * @param bool $currentTimetableNumerator
     * @param int $startOfSemester
     * @param int $weekNumber
     * @return bool
     */
    private function isNumerator(bool $currentTimetableNumerator, int $startOfSemester, int $weekNumber): bool
    {
        $isFirstWeekEven = $startOfSemester % 2 === 0;
        $isSecondWeekEven = $weekNumber % 2 === 0;

        return ($isFirstWeekEven === $isSecondWeekEven) === $currentTimetableNumerator;
    }
}