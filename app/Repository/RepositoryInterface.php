<?php

namespace App\Repository;

use App\DTOs\DtoInterface;

interface RepositoryInterface
{
    public function find(int $id);
    public function findAll();
    public function create(DtoInterface $data);
    public function update(int $id, DtoInterface $data);
    public function delete(int $id);
}