<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Position
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Position",
 *     title="Position",
 *     required={"name"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the position",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Position extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name',];
}
