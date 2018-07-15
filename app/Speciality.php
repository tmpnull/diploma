<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Speciality
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Speciality",
 *     title="Speciality",
 *     required={"name", "number", "abbreviation", "department"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the speciality",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="number",
 *         description="Number of the speciality",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="department_id",
 *         description="Department to which this speciality belongs",
 *         type="integer",
 *     ),
 * )
 *
 * @package App
 */
class Speciality extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'number', 'department_id',];

    /**
     * Get the faculty record associated with the speciality.
     *
     * Many-To-One realisation.
     */
    public function faculty()
    {
        return $this->belongsTo(Department::class);
    }
}
