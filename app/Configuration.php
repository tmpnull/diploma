<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

/**
 * Class Configuration
 *
 * @OAS\Schema(
 *     type="object",
 *     description="Configuration",
 *     title="Configuration",
 *     required={"key"},
 *     @OAS\Property(
 *         property="key",
 *         description="Key of the parameter",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="value",
 *         description="Value for the key",
 *         type="string",
 *     ),
 * )
 *
 * @package App
 */
class Configuration extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];
}
