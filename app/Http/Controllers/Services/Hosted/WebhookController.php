<?php

namespace App\Http\Controllers\Services\Hosted;

use App\Jobs\Transactions\ProcessBitcoin;
use App\Jobs\Transactions\ProcessDash;
use App\Jobs\Transactions\ProcessLitecoin;
use App\Logics\Services\BlockCypher;
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
        $ap = array("hello"=>"hello","hello"=>"hello","hello"=>"hello");
        print_r($ap);
        if ($request->type == 'transfer') {
            return response()->json(["success"=>true]);
            //ProcessBitcoin::dispatch($request->all());
        }
    }
}
