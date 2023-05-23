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
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RecordController extends Controller
{
    use ApiResponseHelpers;

    private $recordService;

    /**
     * @param UserRecordServiceContract $recordService
     */
    public function __construct(UserRecordServiceContract $recordService)
    {
        $this->recordService = $recordService;
        $this->setDefaultSuccessResponse([]);
    }

    /**
     * Method returns vehicle types
     * @param Organization $organization
     * @return JsonResponse
     */
    public function getVehicleTypes(Organization $organization): JsonResponse
    {
        return $this->respondWithSuccess(VehicleTypeResource::collection(VehicleType::where('organization_id', $organization->id)
            ->orderBy('id', 'ASC')
            ->get()));
    }

    /**
     * Method returns visit purposes
     * @param Organization $organization
     * @return JsonResponse
     */
    public function getVisitPurposes(Organization $organization): JsonResponse
    {
        return $this->respondWithSuccess(VisitPurposeResource::collection(VisitPurpose::where('organization_id', $organization->id)
            ->get()));
    }

    /**
     * Method returns places of direction
     * @param Organization $organization
     * @return JsonResponse
     */
    public function getPlaceOfDirections(Organization $organization): JsonResponse
    {
        return  $this->respondWithSuccess(PlaceOfDirectionResource::collection(PlaceOfDirection::where('organization_id', $organization->id)
            ->get()));
    }

    /**
     * Method returns available services
     * @param Organization $organization
     * @return JsonResponse
     */
    public function getServices(Organization $organization): JsonResponse
    {
        return $this->respondWithSuccess(ServiceResource::collection(Service::with('tariffs')
            ->where('organization_id', $organization->id)
            ->get()));
    }

    /**
     * Method returns available tariffs
     * @param Service $service
     * @return JsonResponse
     */
    public function getTariffs(Service $service): JsonResponse
    {
        return $this->respondWithSuccess(TariffResource::collection(Tariff::where('service_id', $service->id)->get()));
    }

    /**
     * Method creates record by user
     * @param Organization $organization
     * @param StoreRecordRequest $request
     * @return JsonResponse
     */
    public function createRecord(Organization $organization, StoreRecordRequest $request)
    {
        try {
            return $this->respondWithSuccess($this->recordService->createRecord($organization, Auth::user(), $request->all()));
        }catch (\Exception $e) {
            report($e);
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Method return user records
     * @return JsonResponse
     */
    public function getRecords(): JsonResponse
    {
        try {
            return $this->respondWithSuccess(RecordResource::collection($this->recordService->getUserRecords(Auth::user(), []))->resource);
        }catch (\Exception $e){
            report($e);
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Method returns user vehicles
     * @return JsonResponse
     */
    public function getUserVehicles(): JsonResponse
    {
        return $this->respondWithSuccess(UserVehicleResource::collection(Vehicle::where('user_id', \auth()->id())
        ->get()));
    }

    /**
     * Method returns user records
     * @param Record $record
     * @return JsonResponse
     */
    public function getRecord(Record $record): JsonResponse
    {
        return $this->respondWithSuccess(RecordResource::make($record->load('vehicle')
            ->load('organization')
            ->load('visit_purpose')
            ->load('payment_note')
            ->load('place_of_direction')
            ->load('checkpoint')
            ->load('vehicle.vehicleType')
            ->load('record_status')
            ->load('tariffs')
            ->load('tariffs.tariff')
            ->load('tariffs.tariff.service')));
    }

    /**
     * Method returns QR image in base64 format from record
     * @param Record $record
     * @return string
     */
    public function getQrImage(Record $record): string
    {
        return base64_encode(QrCode::format('png')
            ->size(300)
            ->backgroundColor(255, 255, 255)
            ->generate(route('security.scan.qr', ['uuid' => $record->record_uuid])));
    }
}
