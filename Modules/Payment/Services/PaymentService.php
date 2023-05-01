<?php
namespace Modules\Payment\Services;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Payment\Contracts\PaymentServiceContract;
use Modules\Payment\Models\Order;

class PaymentService implements PaymentServiceContract
{
    protected $mercaht_id = 520501;

    protected $secret_key = 'eicgATVNHvw9YJUh';

    public function request_link(Record $record, Request $request)
    {
        $description = "Оплата посещения национального парка";
        $salt = Str::random(10);
        $order = Order::create([
            'user_id' => $record->user_id,
            'course_id' => $record->id,
            'payment_amount' => (int)$record->tariffs()->sum('price') + (int)($record->vehicle ? $record->vehicle->vehicleType->price : 0),
            'payment_salt' => $salt
        ]);

        $request_method = 'POST';
        $pg_testing_mode = 1;
        $result_url = "https://bayangnpp.kz/api";
        $success_url = "https://bayangnpp.kz/api/v1";

        $pg_request = [
            'pg_merchant_id' => $this->mercaht_id,
            'pg_amount' => $order->payment_amount,
            'pg_salt' => $salt,
            'pg_order_id' => $order->id,
            'pg_description' => $description,
            'pg_result_url' => $result_url,
            'pg_success_url' => $success_url,
            'request_method' => $request_method,
            'pg_testing_mode' => $pg_testing_mode
        ];

        ksort($pg_request);
        array_unshift($pg_request, 'payment.php');
        array_push($pg_request, $this->secret_key); //add your secret key (you can take it in your personal cabinet on paybox system)


        $pg_request['pg_sig'] = md5(implode(';', $pg_request));

        unset($pg_request[0], $pg_request[1]);
        $query = http_build_query($pg_request);

        $order->update([
            'payment_sig' => $pg_request['pg_sig'],
            'payment_link' => $query,
            'payment_json' => json_encode($pg_request, JSON_UNESCAPED_UNICODE)
        ]);

        return 'https://api.paybox.money/payment.php?' . $query;
    }
}
