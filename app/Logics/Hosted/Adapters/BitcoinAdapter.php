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
use App\Logics\Hosted\Exceptions\BlockchainException;
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
        $api_url = $api;
        $get_token = new Curl;
        $get_token->setHeader('Accept','application/json');
        $get_token->setHeader('Content-Type','application/json');
        $get_token->post($api.'login',array("email"=>$login,"password"=>$pass));
        if($get_token->errorMessage){
            throw new BlockchainException(__('Unable to connect to blockchain network'));
        }
        else{
            $get_token = json_encode($get_token->response);
            $access_token = json_decode($get_token,true);
            print_r($access_token);
            if(isset($access_token['success']) && $access_token['success'] == true){
                $access_token = 'Bearer '.$access_token['token'];
                //echo($access_token);
                $get_token =""; 
            }
            else{
                throw new BlockchainException(__('Unable to connect to blockchain network!'));
            }
        }
    }

    public function generateWallet($label, $passphrase, $userid, $username)
    {
        //$approvals = (int) config()->get('settings.min_tx_confirmations');
        $generate_wallet = new Curl();
        $generate_wallet->setHeader("Authorization",$access_token);
        $generate_wallet->post($api_url.'affan',array('type'=>1,'coin'=>'BTC','userid'=>$userid,'username'=>$username,'passphrase'=>$passphrase));
        if($generate_wallet->errorMessage){
            throw new BlockchainException(__('Unable to generate wallet'));
        }
        else{
            $generate_wallet = json_encode($generate_wallet->response);
            $generate_wallet = json_decode($generate_wallet,true);
            if(isset($generate_wallet['success']) && $generate_wallet['success']==true){
                throw new BlockchainException(__(json_encode($generate_wallet)));
            }
        }
        //return $wallet;
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
