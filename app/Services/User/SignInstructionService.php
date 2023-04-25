<?php

namespace App\Services\User;

use App\Contracts\User\SignInstructionContract;
use App\Models\Instruction;
use App\Models\User;
use App\Models\UserInstructionAccept;

class SignInstructionService implements SignInstructionContract
{
    public function signInstruction(User $user, Instruction $instruction, array $data)
    {
        $data['user_id'] = $user->id;
        $data['instruction_id'] = $instruction->id;
        $data['accepted_at'] = now();
        return UserInstructionAccept::create($data);
    }
}
