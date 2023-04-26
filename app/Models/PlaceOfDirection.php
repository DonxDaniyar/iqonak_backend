<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class PlaceOfDirection extends Model
{
    use Translatable;
    protected $translatable  = ['name'];
    use HasFactory;
}
