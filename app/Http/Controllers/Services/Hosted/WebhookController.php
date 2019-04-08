<?php

namespace App\Http\Controllers\Services\Hosted;

use App\Jobs\Transactions\ProcessBitcoin;
use App\Jobs\Transactions\ProcessKomodo;
use App\Jobs\Transactions\ProcessEthereum;
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
            //return response()->json(["success"=>true]);
            ProcessBitcoin::dispatch($request->all());
        }
    }

    public function handleKomodo(Request $request)
    {
        if ($request->type == 'transfer') {
            //return response()->json(["success"=>true]);
            ProcessKomodo::dispatch($request->all());
        }
    }

    public function handleEthereum(Request $request)
    {
        if ($request->type == 'transfer') {
            //return response()->json(["success"=>true]);
            ProcessEthereum::dispatch($request->all());
        }
    }
}
