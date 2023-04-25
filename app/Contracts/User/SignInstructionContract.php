<?php

namespace App\Contracts\User;

use App\Models\Instruction;
use App\Models\User;

interface SignInstructionContract
{
    public function signInstruction(User $user, Instruction $instruction, array $data);
}
