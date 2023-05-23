<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\User\SignInstructionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignInstructionRequest;
use App\Models\Instruction;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Js;

class InstructionController extends Controller
{
    use ApiResponseHelpers;

    private $signInstructionService;

    /**
     * @param SignInstructionContract $signInstructionService
     */
    public function __construct(SignInstructionContract $signInstructionService)
    {
        $this->signInstructionService = $signInstructionService;
    }

    /**
     * Method returns instructions
     * @param Instruction $instruction
     * @return JsonResponse
     */
    public function getInstruction(Instruction $instruction): JsonResponse
    {
        return $this->respondWithSuccess($instruction);
    }

    /**
     * Methods signs instruction by user
     * @param Instruction $instruction
     * @param SignInstructionRequest $request
     * @return JsonResponse
     */
    public function signInstruction(Instruction $instruction, SignInstructionRequest $request): JsonResponse
    {
        return $this->respondWithSuccess($this->signInstructionService->signInstruction(Auth::user(), $instruction, $request->validated()));
    }
}
