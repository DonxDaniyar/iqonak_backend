<?php
namespace App\Services\Manager;

use App\Contracts\Manager\ManagerRecordServiceContract;
use App\Models\Record;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ManagerRecordService implements ManagerRecordServiceContract
{
    /**
     * Method return records by filter
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getRecordsByFilter(array $data): LengthAwarePaginator
    {
        $query = Record::query();
        //TODO Add filter by array
        return $query->paginate(50);
    }

    /**
     * Method returns record
     * @param User $user
     * @param array $data
     * @return Record
     */
    public function createRecord(User $user, array $data): Record
    {
        $data['manager_id'] = $user->id;
        return Record::create($data);
    }

    /**
     * Method returns bool to deleting operation
     * @param Record $record
     * @return bool
     */
    public function deleteRecord(Record $record): bool
    {
        return DB::transaction(function () use ($record){
            foreach ($record->tariffs as $tariff) {
                $tariff->delete();
            }
            $record->delete();
            return true;
        });
    }
}
