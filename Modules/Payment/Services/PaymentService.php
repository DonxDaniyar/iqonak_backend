<?php
namespace Modules\Payment\Services;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Payment\Contracts\PaymentServiceContract;
use Modules\Payment\Models\Order;

class PaymentService implements PaymentServiceContract
{
    private $mercaht_id;

    private $secret_key;

    public function __construct()
    {
        $this->mercaht_id = config('payment::paybox_merchant_id');
        $this->secret_key = config('payment::paybox_merchant_secret');
    }
    /**
     * Method returns link
     * @param Record $record
     * @param Request $request
     * @return string
     */
    public function request_link(Record $record, Request $request)
    {
        //TODO Change text to lang alias
        $description = "Оплата посещения национального парка";
        $salt = Str::random(10);
        $order = Order::create([
            'user_id' => $record->user_id,
            'record_id' => $record->id,
            'payment_amount' => $record->tariffs()->sum('price') + ($record->vehicle ? $record->vehicle->vehicleType->price : 0) * $record->tenure,
            'payment_salt' => $salt
        ]);
        $request_method = 'POST';
        $pg_testing_mode = 1;
        $result_url = route('payment.api.save');
        $success_url = route('welcome');

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

        $record->update([
            'record_status_id' => 2
        ]);
        $order->update([
            'payment_sig' => $pg_request['pg_sig'],
            'payment_link' => $query,
            'payment_json' => json_encode($pg_request, JSON_UNESCAPED_UNICODE)
        ]);

        return 'https://api.paybox.money/payment.php?' . $query;
    }
}
