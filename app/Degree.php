<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as OAS;

/**
 * Class Degree
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Degree",
 *     title="Degree",
 *     required={"name"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the degree",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Degree extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name',];
}
