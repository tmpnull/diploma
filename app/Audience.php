<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Audience
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Audience",
 *     title="Audience",
 *     required={"name", "buildingId"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the audience",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="building_id",
 *         description="Building to which this audience belongs",
 *         type="integer",
 *     ),
 * )
 *
 * @package App
 */
class Audience extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'building_id',];

    /**
     * Get the faculty record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
