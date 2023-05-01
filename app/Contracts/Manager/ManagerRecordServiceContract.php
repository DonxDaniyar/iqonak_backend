<?php
namespace App\Contracts\Manager;

use App\Models\Record;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;

interface ManagerRecordServiceContract
{
    public function getRecordsByFilter(array $data): LengthAwarePaginator;
    public function createRecord(User $user, array $data): Record;
}
