<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Teacher
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Teacher",
 *     title="Teacher",
 *     required={"userId", "departmentId"},
 *     @OAS\Property(
 *         property="userId",
 *         description="Id of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="departmentId",
 *         description="Department to which this group belongs",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Teacher extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'department_id'
    ];

    /**
     * Get the role record associated with the user.
     *
     * One-To-One realisation.
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }

    /**
     * Get the role record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}
