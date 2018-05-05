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
 *     required={"name", "departmentId"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the group",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="departmentId",
 *         description="Department to which this group belongs",
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
        'name', 'department_id',
    ];

    /**
     * Get the department record associated with the group.
     *
     * Many-To-One realisation.
     */
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
