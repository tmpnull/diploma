<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Role
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Role",
 *     title="Role",
 *     required={"name"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the role",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Role extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name',];
}
