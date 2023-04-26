<?php
namespace App\Contracts\User;

use App\Models\Organization;
use App\Models\User;

interface RecordServiceContract
{
    public function createRecord(Organization $organization, User $user, array $data);
}
