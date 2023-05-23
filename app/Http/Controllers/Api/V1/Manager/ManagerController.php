<?php

namespace App\Http\Controllers\Api\V1\Manager;

use App\Contracts\Manager\ManagerRecordServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreRecordRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Record;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    use ApiResponseHelpers;

    private $recordService;

    /**
     * @param ManagerRecordServiceContract $recordService
     */
    public function __construct(ManagerRecordServiceContract $recordService)
    {
        $this->recordService = $recordService;
    }

    /**
     * Method returns manager information with organization
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondWithSuccess(UserResource::make(User::with('roles')
            ->with('organizations')
            ->where('id', auth()->id())
            ->first()));
    }

    /**
     * Method returns records
     * @return JsonResponse
     */
    public function getRecords(): JsonResponse
    {
        return $this->respondWithSuccess($this->recordService->getRecordsByFilter([]));
    }

    /**
     * Method creates record
     * @param StoreRecordRequest $request
     * @return JsonResponse
     */
    public function createRecord(StoreRecordRequest $request): JsonResponse
    {
        return $this->respondWithSuccess($this->recordService->createRecord(Auth::user(), $request->validated()));
    }

    /**
     * Method deletes record
     * @param Record $record
     * @return JsonResponse
     */
    public function deleteRecord(Record $record): JsonResponse
    {
        return $this->respondWithSuccess($this->recordService->deleteRecord($record));
    }

    /**
     * Method returns user by IIN
     * @param Request $request
     * @return JsonResponse
     */
    public function searchByIIN(Request $request): JsonResponse
    {
        return $this->respondWithSuccess(UserResource::make(User::with('roles')
            ->where('iin', $request->iin)
            ->first()
        ));
    }
}
