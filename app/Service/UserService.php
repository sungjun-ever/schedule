<?php

namespace App\Service;

use App\Repository\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    )
    {
    }

    public function getUserById(int $id): Collection
    {
        $user = $this->userRepository->find($id);

        if (is_null($user)) {
            throw new ModelNotFoundException("User Not Found, id:{$id}");
        }

        return $user;
    }
}