<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function find(int $id): User
    {
        return $this->model->with([
            'team' => function ($query) {
                $query->select(['id', 'team_name']);
            }
        ])
            ->find($id);
    }

    public function getAll(): Collection
    {
        return $this->model->with([
            'team' => function ($query) {
                $query->select(['id', 'team_name']);
            }
        ])
            ->orderBy('id', 'desc')->get();
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
            throw new NotFoundHttpException();
        }

        if (!empty($data['name'])) {
            $user->name = $data['name'];
        }

        if (!empty($data['email'])) {
            $user->email = $data['email'];
        }

        $user->team_id = $data['teamId'];

        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        if ($user->isDirty()) {
            $user->save();
        }

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