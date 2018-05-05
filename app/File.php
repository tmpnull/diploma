<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class File
 *
 * @OAS\Schema(
 *     type="object",
 *     description="File",
 *     title="File",
 *     required={"name", "userId"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the file",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="userId",
 *         description="User owner of this file",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class File extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'path',
    ];



    /**
     * Get the user record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function faculty()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'path'
    ];
}
