<?php

namespace App\Http\Controllers\Ajax\Payments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Services\Contracts\PaypalServiceContract;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    //public function create (CreateOrderRequest $request)
    public function create (CreateOrderRequest $request, PaypalServiceContract $paypal)
    {
        //dd($request->validated());
        return app()->call([$paypal, 'create'], compact('request'));
    }

    public function capture ()
    {
        
    }
}
