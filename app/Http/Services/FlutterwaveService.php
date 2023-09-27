<?php

namespace App\Http\Services;

use App\Traits\ConsumesExternalServices;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class FlutterwaveService
{
    use ConsumesExternalServices;

    protected $baseUri;
    protected $clientKey;
    protected $clientSecret;
    protected $clientSecretHash;

    public function __construct()
    {
        $this->baseUri = config('services.flutterwave.base_uri');
        $this->clientKey = config('services.flutterwave.client_key');
        $this->clientSecret = config('services.flutterwave.client_secret');
        $this->clientSecretHash = config('services.flutterwave.client_secret_hash');
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        $response = json_decode($response);
        return $response->data;
    }

    public function resolveAccessToken(): string
    {
        return "Bearer $this->clientSecret";
    }

    public function handlePayment($value, $currency)
    {
        $reference = $this->generateReference('lgz');
        session()->put('paymentReferenceId', $reference);

        $payment = $this->initiatePayment($value, $currency, $reference);
        return redirect($payment->link);
    }

    public function initiatePayment($value, $currency, $reference)
    {
        $billing_address = json_decode(json_encode(Session::get('billing_address')));

        return $this->makeRequest(
            'POST',
            '/v3/payments',
            [],
            [
                'tx_ref' => $reference,
                'amount' => round($value * $this->resolveFactor($currency)),
                'currency' => strtoupper($currency),
                'redirect_url' => route('approval'),
                'customer' => [
                    'email' => $billing_address->email,
                    'name' => $billing_address->name,
                    'order-number' => Session::get('order_number', 'nil')
                ],
                'customizations' => [
                    'title' => config('app.name'),
                    'logo' => config('app.url') . "/logo.png",
                    'description' => 'Payment for products'
                ]
            ],
            [],
            $isJsonRequest = true
        );
    }

    public function handleApproval()
    {
        $data = ['success' => false, 'amount' => '', 'message' => 'We can not capture the payment. Please, Try again!'];
        if (session()->has('paymentReferenceId')) {
            $paymentReferenceId = session()->get('paymentReferenceId');
            if (request()->query('status') === "cancelled" || !request()->has('transaction_id')) {
                $data['message'] = "Payment cancelled";

                return $data;
            }

            // get transaction ref from callback
            $transactionReference = request()->query('tx_ref');

            if ($paymentReferenceId !== $transactionReference) {
                return $data;
            }

            // get transaction id from callback
            $transactionID = request()->query('transaction_id');

            $confirmation = $this->confirmPayment($transactionID);

            Log::info("Payment Verification: ".json_encode($confirmation));

            if ($confirmation->status === 'successful') {
                // $name = $confirmation->customer->name;
                $currency = strtoupper($confirmation->currency);
                $amount = $confirmation->amount / $this->resolveFactor($currency);

                $data['success'] = true;
                $data['amount'] = $amount;
                $data['message'] = 'Payment Successful!';
            }
        }

        return $data;
    }

    public function confirmPayment($transactionID)
    {
        Log::info("confirming $transactionID");
        return $this->makeRequest(
            'GET',
            "/v3/transactions/$transactionID/verify",
            [],
            [],
            [],
            true
        );
    }

    public function generateReference(string $transactionPrefix = NULL): string
    {
        if ($transactionPrefix) {
            return $transactionPrefix . '_' . uniqid(time());
        }
        return 'flw_' . uniqid(time());
    }

    public function resolveFactor($currency): int
    {
        $zeroDecimalCurrencies = ['JPY'];

        return 1;
    }

}
