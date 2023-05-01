<?php
namespace Modules\Payment\Contracts;

use App\Models\Record;
use Illuminate\Http\Request;

interface PaymentServiceContract
{
    public function request_link(Record $record, Request $request);
}
