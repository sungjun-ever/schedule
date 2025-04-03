<?php

namespace App\Repository;

use App\DTO\DtoInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function create(DtoInterface $data)
    {
        $this->model->create($data);
    }

    public function update(int $id, DtoInterface $data)
    {
        $this->model->find($id)->update($data);
    }

    public function delete(int $id)
    {
        $this->model->find($id)->softDeletes();
    }
}