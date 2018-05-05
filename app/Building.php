<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Building
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Building",
 *     title="Building",
 *     required={"name", "abbreviation"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the building",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="abbreviation",
 *         description="Abbreviation of the building",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Building extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'abbreviation',
    ];
}
