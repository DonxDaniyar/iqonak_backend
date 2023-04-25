<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\User\SignInstructionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignInstructionRequest;
use App\Models\Instruction;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructionController extends Controller
{
    use ApiResponseHelpers;

    private $signInstructionService;

    public function __construct(SignInstructionContract $signInstructionService)
    {
        $this->signInstructionService = $signInstructionService;
    }

    public function getInstruction(Instruction $instruction)
    {
        return $this->respondWithSuccess($instruction);
    }
    public function signInstruction(Instruction $instruction, SignInstructionRequest $request)
    {
        return $this->respondWithSuccess($this->signInstructionService->signInstruction(Auth::user(), $instruction, $request->validated()));
    }
}
