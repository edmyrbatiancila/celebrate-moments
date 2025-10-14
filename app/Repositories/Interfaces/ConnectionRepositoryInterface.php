<?php

namespace App\Repositories\Interfaces;

use App\Models\Connection;
use Illuminate\Database\Eloquent\Collection;

interface ConnectionRepositoryInterface
{
    public function getAllConnections(): Collection;

    public function getConnectionById(int $id): ?Connection;

    public function createConnection(array $data): Connection;

    public function updateConnection(int $id, array $data): bool;

    public function deleteConnection(int $id): bool;
}
