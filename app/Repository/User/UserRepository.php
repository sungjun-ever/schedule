<?php

namespace App\Repository\User;

use App\DTOs\DtoInterface;
use App\DTOs\User\StoreUserDto;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->orderBy('id', 'desc')->get();
    }

    /**
     * 사용자 등록
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): void
    {
        $user = $this->model->find($id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $user->update($data);
    }

    /**
     * 팀 기준 사용자 가져오기
     * @param int $id
     * @return Collection|null
     */
    public function getMemberByTeam(int $id): ?Collection
    {
        return $this->model->where('team_id', $id)->get();
    }

}