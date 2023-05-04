<?php

namespace App\Services\User;

use App\Contracts\User\UserRecordServiceContract;
use App\Models\Organization;
use App\Models\Record;
use App\Models\RecordTariff;
use App\Models\Service;
use App\Models\Tariff;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRecordService implements UserRecordServiceContract
{
    public function createRecord(Organization $organization, User $user, array $data)
    {
        $data['user_id'] = $user->id;
        $data['organization_id'] = $organization->id;
        if (!$data['vehicle_id']) {
            $vehicle = $this->createVehicle($data);
            $data['vehicle_id'] = $vehicle->id;
        }
        $record = Record::create($data);
        foreach (json_decode($data['services']) as $service) {
            $service = Service::find($service);
            if (!$service) {
                throw new \Exception("Услуга не найдена");
            }
            if ($service->is_required === true) {
                $tariff = Tariff::where('service_id', $service->id)
                    ->first();
                if ($tariff) {
                    RecordTariff::create([
                        'record_id' => $record->id,
                        'tariff_id' => $tariff->id,
                        'price' => ($tariff->price * ($data['children_people_in_group'] + $data['student_in_group'] + $data['adult_people_in_group'])) * $data['tenure'],
                    ]);
                }
                continue;
            }
            if (isset($data['children_people_in_group'])) {
                $tariff = Tariff::where('service_id', $service->id)
                    ->where('is_kid', 1)
                    ->first();

                if ($tariff) {
                    RecordTariff::create([
                        'record_id' => $record->id,
                        'tariff_id' => $tariff->id,
                        'price' => ($tariff->price * $data['children_people_in_group']) * $data['tenure'],
                    ]);
                }
            }
            if (isset($data['student_in_group'])) {
                $tariff = Tariff::where('service_id', $service->id)
                    ->where('is_student', 1)
                    ->first();

                if ($tariff) {
                    RecordTariff::create([
                        'record_id' => $record->id,
                        'tariff_id' => $tariff->id,
                        'price' => ($tariff->price * $data['student_in_group']) * $data['tenure'],
                    ]);
                }
            }
            if (isset($data['adult_people_in_group'])) {
                $tariff = Tariff::where('service_id', $service->id)
                    ->where('is_adult', 1)
                    ->first();

                if ($tariff) {
                    RecordTariff::create([
                        'record_id' => $record->id,
                        'tariff_id' => $tariff->id,
                        'price' => ($tariff->price * $data['adult_people_in_group']) * $data['tenure'],
                    ]);
                }
            }
        }
        return $record;
    }

    public function getUserRecords(User $user, array $data): LengthAwarePaginator
    {
        $query = Record::query();
        $query->with('vehicle')
            ->with('organization')
            ->with('visit_purpose')
            ->with('payment_note')
            ->with('place_of_direction')
            ->with('checkpoint');
        return $query->paginate(50);
    }

    public function createVehicle(array $data): Vehicle
    {
        return Vehicle::create($data);
    }
}
