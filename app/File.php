<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

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
    protected $fillable = ['name', 'user_id', 'path', 'is_public'];

    /**
     * Get the user record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
