<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Student
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Student",
 *     title="Student",
 *     required={"userId", "groupId"},
 *     @OAS\Property(
 *         property="userId",
 *         description="Id of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="groupId",
 *         description="Group to which this group belongs",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Student extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'group_id',];

    /**
     * Get the role record associated with the user.
     *
     * One-To-One realisation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the role record associated with the group.
     *
     * Many-To-One realisation.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
