<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
    public function tariffs(): HasMany
    {
        return $this->hasMany(RecordTariff::class);
    }
    public function vehicle(): HasOne
    {
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }
    public function scans(): HasMany
    {
        return $this->hasMany(RecordScan::class);
    }
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    public function visit_purpose(): BelongsTo
    {
        return $this->belongsTo(VisitPurpose::class);
    }
    public function payment_note(): BelongsTo
    {
        return $this->belongsTo(PaymentNote::class);
    }
    public function place_of_direction(): BelongsTo
    {
        return $this->belongsTo(PlaceOfDirection::class);
    }
    public function checkpoint(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class);
    }
    public function record_status()
    {
        return $this->belongsTo(RecordStatus::class);
    }
}
