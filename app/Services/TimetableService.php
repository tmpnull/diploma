<?php

namespace App\Services;

use App\Timetable;
use App\Http\Resources\Timetable as TimetableResource;

class TimetableService
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TimetableResource::collection(Timetable::all());
    }

    /**
     * @param int $id
     * @return TimetableResource
     */
    public function show(int $id)
    {
        return TimetableResource::make(Timetable::find($id));
    }

    /**
     * @param int $id
     * @return TimetableResource
     */
    public function showByGroupId(int $id)
    {
        $timetable = Timetable::where('group_id', '=', $id);
        return TimetableResource::make($timetable);
    }

    /**
     * @param int $id
     * @return TimetableResource
     */
    public function showByTeacherId(int $id)
    {

    }

    /**
     * @param array $data
     * @return TimetableResource
     */
    public function store(array $data)
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
    public function update(int $id, array $data)
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
    public function destroy(int $id)
    {
        return Timetable::destroy($id);
    }
}