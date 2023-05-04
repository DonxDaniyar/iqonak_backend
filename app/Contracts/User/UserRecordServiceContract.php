<?php
namespace App\Contracts\User;

use App\Models\Organization;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRecordServiceContract
{
    public function createRecord(Organization $organization, User $user, array $data);
    public function getUserRecords(User $user, array $data):LengthAwarePaginator;
    public function createVehicle(array $data): Vehicle;
}
