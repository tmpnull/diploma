<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Group",
 *     title="Group",
 *     required={"name", "specialityId"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the group",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="specialityId",
 *         description="Speciality to which this group belongs",
 *         type="integer",
 *     ),
 * )
 *
 * @package App
 */
class Group extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'speciality_id',
    ];

    /**
     * Get the speciality record associated with the group.
     *
     * Many-To-One realisation.
     */
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
}
