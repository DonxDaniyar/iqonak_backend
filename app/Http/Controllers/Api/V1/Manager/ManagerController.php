<?php

namespace App\Http\Controllers\Api\V1\Manager;

use App\Contracts\Manager\ManagerRecordServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreRecordRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Record;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    use ApiResponseHelpers;

    private $recordService;

    public function __construct(ManagerRecordServiceContract $recordService)
    {
        $this->recordService = $recordService;
    }

    public function getMe()
    {
        return $this->respondWithSuccess(UserResource::make(User::with('roles')
            ->with('organizations')
            ->where('id', auth()->id())
            ->first()));
    }
    public function getRecords()
    {
        return $this->respondWithSuccess($this->recordService->getRecordsByFilter([]));
    }
    public function createRecord(StoreRecordRequest $request)
    {
        return $this->respondWithSuccess($this->recordService->createRecord(Auth::user(), $request->validated()));
    }
    public function deleteRecord(Record $record)
    {
        return $this->respondWithSuccess($this->recordService->deleteRecord($record));
    }
    public function searchByIIN(Request $request)
    {
        return $this->respondWithSuccess(UserResource::make(User::with('roles')
            ->where('iin', $request->iin)
            ->first()
        ));
    }
}
