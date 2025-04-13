<?php

namespace App\Service;

use App\DTOs\User\UpdateUserDto;
use App\DTOs\User\StoreUserDto;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

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
    public function findUserById(int $id): User
    {
        $user = $this->userRepository->find($id);

        if (is_null($user)) {
            throw new ModelNotFoundException("User Not Found, id:{$id}");
        }

        return $user;
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAll();
    }

    /**
     * @param StoreUserDto $userDto
     * @return User
     */
    public function storeUser(StoreUserDto $userDto): User
    {
        return $this->userRepository->create([
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => $userDto->password,
            'team_id' => $userDto->teamId
        ]);
    }

    /**
     * @param int $id
     * @param UpdateUserDto $userDto
     * @return void
     * @throws UserNotFoundException
     */
    public function updateUser(int $id, UpdateUserDto $userDto): void
    {
        $data = [];

        foreach ($userDto as $field => $value) {
            if ($field === 'password' && empty($value)) {
                continue;
            }
            $data[$field] = $value;
        }

        $this->userRepository->update($id, $data);
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