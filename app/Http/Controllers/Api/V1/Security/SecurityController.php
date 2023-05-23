<?php

namespace App\Http\Controllers\Api\V1\Security;

use App\Http\Controllers\Controller;
use App\Http\Resources\Record\RecordResource;
use App\Models\Record;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    use ApiResponseHelpers;

    /**
     * Method scans qr image by security
     * @param $uuid
     * @return JsonResponse
     */
    public function scan_qr($uuid): JsonResponse
    {
        $record = Record::where('record_uuid', $uuid)->first();
        if(!$record){
            return $this->respondNotFound("Record not found");
        }
        if(!$record->scanned_at){
            $record->update([
                'scanned_at' => now()
            ]);
        }
        $record->scans()->create([
            'security_id' => auth()->id(),
            'scanned_at' => now()
        ]);

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
}
