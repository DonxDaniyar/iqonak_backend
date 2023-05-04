<?php

namespace Modules\Payment\Http\Controllers;

use App\Models\Record;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Payment\Models\Order;

class PaymentController extends Controller
{
    protected $mercaht_id = 542439;

    protected $secret_key = 'xEPlWCarA63QOIEE';
}
