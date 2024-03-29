<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Swagger\Annotations as OAS;
use Laravel\Passport\HasApiTokens;

/**
 * Class File
 *
 * @OAS\Schema(
 *     type="object",
 *     description="User",
 *     title="User",
 *     required={"name", "email", "surname", "patronymic", "gender"},
 *     @OAS\Property(
 *         property="name",
 *         description="Name of the file",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="email",
 *         description="Email of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="surname",
 *         description="Surname of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="patronymic",
 *         description="Patronymic of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="date_of_birth",
 *         description="Date of birth of the user",
 *         type="string",
 *         format="date",
 *     ),
 *     @OAS\Property(
 *         property="password",
 *         description="Password of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="mobile_phone",
 *         description="Mobile phone of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="work_phone",
 *         description="Work phone of the user",
 *         type="string",
 *     ),
 *     @OAS\Property(
 *         property="gender",
 *         description="Gender of the user",
 *         type="boolean",
 *     ),
 *     @OAS\Property(
 *         property="roleId",
 *         description="Role of the user",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="positionId",
 *         description="Position of the user",
 *         type="integer",
 *     ),
 *     @OAS\Property(
 *         property="degreeId",
 *         description="Degree of the user",
 *         type="integer",
 *     ),
 * )
 *
 * @package App
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'date_of_birth',
        'email',
        'password',
        'mobile_phone',
        'work_phone',
        'gender',
        'photo',
        'role_id',
        'position_id',
        'degree_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * Get the degree record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    /**
     * Get the role record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the position record associated with the department.
     *
     * Many-To-One realisation.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function authorizeRoles($roles)
    {
        if (\is_array($roles)) {
            return $this->hasAnyRole($roles);
        }

        return $this->hasRole($roles);
    }

    /**
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles): bool
    {
        $userRole = $userRole = $this->role();

        if ($userRole) {
            return \in_array($this->role()->first()->name, $roles, false);
        }

        return false;
    }

    public function hasRole($role): bool
    {
        $userRole = $this->role()->first();
        return $userRole ? $userRole->name === $role : false;
    }
}
