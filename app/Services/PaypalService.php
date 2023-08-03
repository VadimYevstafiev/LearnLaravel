<?php

namespace App\Services;

use App\Http\Requests\CreateOrderRequest;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Services\Contracts\PaypalServiceContract;
use Srmklive\PayPal\Services\PayPal;

class PaypalService implements PaypalServiceContract
{
    const PAYMENT_SYSTEM = 'PAYPAL';

    protected PayPal $payPalClient;

    public function __construct()
    {
        $this->payPalClient = new PayPal();
        $this->payPalClient->setApiCredentials(config('paypal'));

        dd("config('paypal')", config('paypal'));
       // dd('$this->payPalClient->getAccessToken()', $this->payPalClient);

        $this->payPalClient->setAccessToken($this->payPalClient->getAccessToken());
    }

    public function create(CreateOrderRequest $request, OrderRepositoryContract $repository)
    {
        dd($request->validated());
    }

    public function capture(string $vendorOrderId, OrderRepositoryContract $repository)
    {
        
    }
}
