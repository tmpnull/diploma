<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Department
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Department",
 *     title="Department",
 *     required={"name", "number", "abbreviation", "facultyId"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the department",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="number",
 *         description="Number of the department",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="abbreviation",
 *         description="Abbreviation of the department",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="facultyId",
 *         description="Faculty to which this department belongs",
 *         type="integer",
 *     ),
 * )
 *
 * @package App
 */
class Department extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'abbreviation', 'faculty_id'
    ];

    /**
     * Get the faculty record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function faculty()
    {
        return $this->belongsTo('App\Faculty');
    }
}
