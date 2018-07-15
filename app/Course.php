<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Course
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Course",
 *     title="Course",
 *     required={"name"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the course",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="teacherId",
 *         description="Id of the teacher",
 *         type="integer",
 *     ),
 * )
 *
 * @package App
 */
class Course extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'teacher_id'];

    /**
     * Get the faculty record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
