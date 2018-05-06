<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Faculty
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Faculty",
 *     title="Faculty",
 *     required={"name", "number", "abbreviation"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the faculty",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="number",
 *         description="Number of the faculty",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="abbreviation",
 *         description="Abbreviation of the faculty",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Faculty extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'number',
        'abbreviation',
    ];
}
