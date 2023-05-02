<?php

namespace App\Http\Controllers\Api\V1\Security;

use App\Http\Controllers\Controller;
use App\Models\Record;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    use ApiResponseHelpers;
    public function scan_qr($uuid)
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

        return $this->respondWithSuccess($record);
    }
}
