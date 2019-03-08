<?php

namespace App\Http\Controllers\Services\Hosted;

use App\Jobs\Transactions\ProcessBitcoin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * @param Request $request
     */
    public function handleBitcoin(Request $request)
    {
        if ($request->type == 'transfer') {
            return response()->json(["success"=>true]);
            //ProcessBitcoin::dispatch($request->all());
        }
    }
}
