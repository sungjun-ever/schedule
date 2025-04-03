<?php

namespace App\Repository\User;

use App\DTO\DtoInterface;
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

    /**
     * 사용자 등록
     * @param DtoInterface $data
     * @return User
     */
    public function create(DtoInterface $data): User
    {
        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;
        $user->team_id = $data->teamId ?: null;
        $user->save();

        return $user;
    }

    public function update(int $id, DtoInterface $data): void
    {
        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->team_id = $data->teamId ?: null;

        if ($user->isDirty()) {
            $user->save();
        }
    }

    /**
     * 팀 기준 사용자 가져오기
     * @param int $id
     * @return Collection|null
     */
    public function findMemberByTeam(int $id): ?Collection
    {
        return $this->model->where('team_id', $id)->get();
    }

}