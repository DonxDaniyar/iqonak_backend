<?php
namespace App\Services\Manager;

use App\Contracts\Manager\ManagerRecordServiceContract;
use App\Models\Record;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ManagerRecordService implements ManagerRecordServiceContract
{
    public function getRecordsByFilter(array $data): LengthAwarePaginator
    {
        $query = Record::query();
        return $query->paginate(50);
    }
    public function createRecord(User $user, array $data): Record
    {
        $data['manager_id'] = $user->id;
        return Record::create($data);
    }
}
