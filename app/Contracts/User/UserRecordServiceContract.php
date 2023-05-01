<?php
namespace App\Contracts\User;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRecordServiceContract
{
    public function createRecord(Organization $organization, User $user, array $data);
    public function getUserRecords(User $user, array $data):LengthAwarePaginator;
}
