<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Timetable
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Timetable",
 *     title="Timetable",
 *     required={"courseId", "gr"},
 *     @OAS\Property(
 *         property="courseId",
 *         description="Id of the course",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="day_of_week",
 *         description="Day of week",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="number",
 *         description="Number of course in the day",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="is_numerator",
 *         description="Is course only on numerator week",
 *         type="boolean",
 *     ),
 *      @OAS\Property(
 *         property="is_first_semester",
 *         description="Is course only on first semester",
 *         type="boolean",
 *     ),
 *     @OAS\Property(
 *         property="group_id",
 *         description="Id of the group",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="audience_id",
 *         description="Id of the audience",
 *         type="integer",
 *     ),
 * )
 *
 * @package App
 */
class Timetable extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'day_of_week',
        'number',
        'is_numerator',
        'is_first_semester',
        'group_id',
        'audience_id',
    ];

    /**
     * Get the course record associated with the user.
     *
     * One-To-Many realisation.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the role record associated with the department.
     *
     * Many-To-Many realisation.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the role record associated with the department.
     *
     * Many-To-Many realisation.
     */
    public function audience()
    {
        return $this->belongsTo(Audience::class);
    }
}
