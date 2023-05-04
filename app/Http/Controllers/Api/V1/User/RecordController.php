<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Contracts\User\UserRecordServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRecordRequest;
use App\Http\Resources\Record\RecordResource;
use App\Http\Resources\User\Lists\PlaceOfDirectionResource;
use App\Http\Resources\User\Lists\ServiceResource;
use App\Http\Resources\User\Lists\TariffResource;
use App\Http\Resources\User\Lists\VehicleTypeResource;
use App\Http\Resources\User\Lists\VisitPurposeResource;
use App\Http\Resources\User\UserVehicleResource;
use App\Models\Organization;
use App\Models\PlaceOfDirection;
use App\Models\Record;
use App\Models\Service;
use App\Models\Tariff;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\VisitPurpose;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RecordController extends Controller
{
    use ApiResponseHelpers;

    private $recordService;

    public function __construct(UserRecordServiceContract $recordService)
    {
        $this->recordService = $recordService;
        $this->setDefaultSuccessResponse([]);
    }

    public function getVehicleTypes(Organization $organization): JsonResponse
    {
        return $this->respondWithSuccess(VehicleTypeResource::collection(VehicleType::where('organization_id', $organization->id)
            ->orderBy('id', 'ASC')
            ->get()));
    }
    public function getVisitPurposes(Organization $organization): JsonResponse
    {
        return $this->respondWithSuccess(VisitPurposeResource::collection(VisitPurpose::where('organization_id', $organization->id)
            ->get()));
    }
    public function getPlaceOfDirections(Organization $organization): JsonResponse
    {
        return  $this->respondWithSuccess(PlaceOfDirectionResource::collection(PlaceOfDirection::where('organization_id', $organization->id)
            ->get()));
    }
    public function getServices(Organization $organization): JsonResponse
    {
        return $this->respondWithSuccess(ServiceResource::collection(Service::with('tariffs')
            ->where('organization_id', $organization->id)
            ->get()));
    }
    public function getTariffs(Service $service): JsonResponse
    {
        return $this->respondWithSuccess(TariffResource::collection(Tariff::where('service_id', $service->id)->get()));
    }
    public function createRecord(Organization $organization, StoreRecordRequest $request)
    {
        try {
            return $this->respondWithSuccess($this->recordService->createRecord($organization, Auth::user(), $request->all()));
        }catch (\Exception $e) {
            report($e);
            return $this->respondError($e->getMessage());
        }
    }
    public function getRecords()
    {
        try {
            return $this->respondWithSuccess(RecordResource::collection($this->recordService->getUserRecords(Auth::user(), []))->resource);
        }catch (\Exception $e){
            report($e);
            return $this->respondError($e->getMessage());
        }
    }
    public function getUserVehicles()
    {
        return $this->respondWithSuccess(UserVehicleResource::collection(Vehicle::where('user_id', \auth()->id())
        ->get()));
    }
    public function getRecord(Record $record)
    {
        return $this->respondWithSuccess(RecordResource::make($record->load('vehicle')
            ->load('organization')
            ->load('visit_purpose')
            ->load('payment_note')
            ->load('place_of_direction')
            ->load('checkpoint')
            ->load('vehicle.vehicleType')));
    }
    public function getQrImage(Record $record)
    {
        return QrCode::size(200)
            ->backgroundColor(255, 255, 255)
            ->gradient(2, 119, 187,0, 0, 0, 'vertical')
            ->generate($record->record_uuid);
    }
}
