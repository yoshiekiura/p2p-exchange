<?php
/**
 * ======================================================================================================
 * File Name: BitcoinAdapter.php
 * ======================================================================================================
 * Author: affankhan43
 *
 * ------------------------------------------------------------------------------------------------------
 */

namespace App\Logics\Hosted\Adapters;


use App\Logics\Services\BlockCypher;
use App\Models\BitcoinAddress;
use App\Models\BitcoinTransaction;
use App\Models\BitcoinWallet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Curl\Curl;

class BitcoinAdapter
{
    /**
     * Default wallet name
     *
     * @var string
     */
    protected $coin;

    /**
     * BitcoinAdapter constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        include __DIR__.'/../lost/.env';
        $get_token = new Curl;
        $get_token->setHeader('Accept','application/json');
        $get_token->setHeader('Content-Type','application/json');
        $get_token->post($api.'login',array("email"=>$login,"password"=>$pass));
        if($get_token->errorMessage){
            return response()->json(['success'=>false,'message'=>'Connection Failed']);
        }
        else{
            print_r($get_token->response);
            $access_token = json_decode($get_token->response,true);
            if(isset($access_token['success']) && $access_token['success'] == true){
                $access_token = $access_token['token'];
                print_r($access_token);
                $get_token =""; 
            }
            else{
                return response()->json(['success'=>false,'message'=>'Connection Failed!']);
            }
        }
    }

    /**
     * Update input balance
     *
     * @param BitcoinWallet $wallet
     * @param $transfer
     */
    public function updateInputBalance($wallet, $transfer)
    {
        $wallet->decrement('balance', abs($transfer['value']));
    }

    /**
     * Update output balance
     *
     * @param $output
     * @param int $amount
     */
    public function updateOutputBalance($output, $amount = 0)
    {
        if (!is_array($output)) {
            $address = BitcoinAddress::where('address', $output);

            $address->first()->wallet->increment('balance', $amount);
        } else {
            foreach ($output as $out) {
                $address = BitcoinAddress::where('address', $out['address']);

                $address->first()->wallet->increment('balance', $out['amount']);
            }
        }
    }

    /**
     * @param $id
     * @return string
     */
    private function getWebhookUrl()
    {
        $base_url = request()->getBaseUrl();

        //TODO: Test Purpose. Please Remove before production
        if (app()->environment() === 'local') {
            URL::forceRootUrl(config('app.url'));
        }

        $webhook = route('bitgo.hook.btc');

        //TODO: Test Purpose. Please Remove before production
        if (app()->environment() === 'local') {
            URL::forceRootUrl($base_url);
        }

        return $webhook;
    }
}
