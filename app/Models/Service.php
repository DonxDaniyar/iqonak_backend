<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;

class Service extends Model
{
    use Translatable;
    protected $translatable  = ['name'];
    use HasFactory;
    public function tariffs(): HasMany
    {
        return $this->hasMany(Tariff::class);
    }
}
