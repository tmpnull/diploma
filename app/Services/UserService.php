<?php

namespace App\Services;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * @param int|string $id
     *
     * @return UserResource
     */
    public function show($id)
    {
        return UserResource::make(User::find($id));
    }

    /**
     * @param array $data
     *
     * @return UserResource
     */
    public function store(array $data)
    {
        /** @var User $user */
        $user = new User($data);
        $user->setAttribute('password', bcrypt($user->getAttribute('password')));
        $user->save();

        return UserResource::make($user);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return UserResource
     */
    public function update(int $id, array $data)
    {
        /** @var User $user */
        $user = User::find($id);
        $user->update($data);

        return UserResource::make($user);
    }

    /**
     * @param int $id
     *
     * @return int
     */
    public function destroy(int $id)
    {
        return User::destroy($id);
    }

    public function me()
    {
        return UserResource::make(User::with('role')->find(Auth::user()['id']));
    }
}
