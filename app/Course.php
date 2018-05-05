<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Course",
 *     title="Course",
 *     required={"name"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the course",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Course extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}