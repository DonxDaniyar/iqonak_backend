<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Record extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->record_uuid = (string) Str::uuid();
        });
    }
    public function tariffs()
    {
        return $this->hasMany(RecordTariff::class);
    }
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }
    public function scans()
    {
        return $this->hasMany(RecordScan::class);
    }
}
