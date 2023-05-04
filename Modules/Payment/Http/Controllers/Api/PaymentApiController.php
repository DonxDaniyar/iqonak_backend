<?php

namespace Modules\Payment\Http\Controllers\Api;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payment\Contracts\PaymentServiceContract;
use Modules\Payment\Models\Order;

class PaymentApiController extends Controller
{
    private $paymentService;

    public function __construct(PaymentServiceContract $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function request_link(Record $record, Request $request)
    {
        return $this->paymentService->request_link($record, $request);
    }
    public function save_payment(Request $request)
    {
        $request->validate([
            'pg_order_id' => 'required|integer',
            'pg_payment_id' => 'required|integer',
            'pg_amount' => 'required|numeric',
            'pg_currency' => 'required|string|max:3',
            'pg_sig' => 'required'
        ]);

        $order = Order::where('id', $request->pg_order_id)
            ->first();

        if ($order && $request->pg_payment_date) {
            $record = Record::find($order->record_id);
            $record->update([
                'record_status_id' => 3
            ]);
            $order->update([
                'payment_id' => $request->pg_payment_id,
                'payment_user_contact_email' => $request->pg_user_contact_email,
                'payment_user_contact_phone' => $request->pg_user_phone,
                'payment_card_pan' => $request->pg_card_pan,
                'payment_card_exp' => $request->pg_card_exp,
                'payment_card_owner' => $request->pg_card_owner,
                'payment_date' => $request->pg_payment_date,
                'payment_description' => $request->pg_description
            ]);

            //Ответ в формате xml для paybox
            $responseData = [
                'pg_salt' => $request->pg_salt,
                'pg_sig' => $request->pg_sig,
                'pg_status' => 'ok',
                'pg_description' => 'Заказ успешно оплачен!'
            ];

            return response()->xml($responseData);
        } else {

            $responseData = [
                'pg_salt' => $request->pg_salt,
                'pg_sig' => $request->pg_sig,
                'pg_status' => 'rejected',
                'pg_description' => 'Платеж не был успешно завершен!'
            ];

            return response()->xml($responseData);
        }
    }
}
