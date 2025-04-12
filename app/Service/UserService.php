<?php

namespace App\Service;

use App\DTOs\User\UpdateUserDto;
use App\DTOs\User\StoreUserDto;
use App\Models\User;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User
    {
        $user = $this->userRepository->find($id);

        if (is_null($user)) {
            throw new ModelNotFoundException("User Not Found, id:{$id}");
        }

        return $user;
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param StoreUserDto $userDto
     * @return User
     */
    public function storeUser(StoreUserDto $userDto): User
    {
        return $this->userRepository->create($userDto);
    }

    /**
     * @param int $id
     * @param UpdateUserDto $userDto
     * @return void
     */
    public function updateUser(int $id, UpdateUserDto $userDto): void
    {
        $this->userRepository->update($id, $userDto);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->userRepository->delete($id);
    }
}