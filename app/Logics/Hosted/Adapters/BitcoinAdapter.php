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
     * Default wallet name
     *
     * @var string
     */
    private $accesstoken;
    private $api_url;

    /**
     * BitcoinAdapter constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        include __DIR__.'/../lost/.env';
        $this->api_url = $api;
        $get_token = new Curl;
        $get_token->setHeader('Accept','application/json');
        $get_token->setHeader('Content-Type','application/json');
        $get_token->post($api.'login',array("email"=>$login,"password"=>$pass));
        if($get_token->errorMessage){
            throw new BlockchainException(__('Unable to connect to blockchain network'));
        }
        else{
            $get_token = json_encode($get_token->response);
            $access_token1 = json_decode($get_token,true);
            if(!isset($access_token1['token'])){
                throw new BlockchainException(__('Unable to connect to blockchain network!'));
            }
        }
        $this->accesstoken = 'Bearer '.$access_token1['token'];
    }

    public function generateWallet($label, $passphrase, $userid, $username)
    {
        //$approvals = (int) config()->get('settings.min_tx_confirmations');
        $generate_wallet = new Curl();
        $generate_wallet->setHeader("Authorization",$this->accesstoken);
        $api_url = $this->api_url;
        $generate_wallet->post($api_url.'createWallet',array('type'=>1,'coin'=>'BTC','userid'=>$userid,'username'=>$username,'passphrase'=>$passphrase));
        if($generate_wallet->errorMessage){
            throw new BlockchainException(__('Unable to generate wallet'));
            //throw new BlockchainException(__(json_encode($generate_wallet->response)));
        }
        else{
            $generate_wallet = json_encode($generate_wallet->response);
            $generate_wallet = json_decode($generate_wallet,true);
            if(isset($generate_wallet['success']) && $generate_wallet['success']==true){
                $wallet = array("id"=>$generate_wallet['wallet_id'],"keys"=>$generate_wallet['keys'],"confirmedBalance"=>$generate_wallet['balance'],"label"=>$generate_wallet['category'],"receiveAddress"=>$generate_wallet['address']);
                return $wallet;
            }
            else{
                throw new BlockchainException(__(json_encode($generate_wallet)));
            }
        }
    }

    public function generateEscrowWallet($label, $passphrase)
    {
        //$approvals = (int) config()->get('settings.min_tx_confirmations');
        $generate_wallet = new Curl();
        $generate_wallet->setHeader("Authorization",$this->accesstoken);
        $api_url = $this->api_url;
        $generate_wallet->post($api_url.'createWallet',array('type'=>2,'coin'=>'BTC','passphrase'=>$passphrase));
        if($generate_wallet->errorMessage){
            throw new BlockchainException(__('Unable to generate wallet'));
            //throw new BlockchainException(__(json_encode($generate_wallet->response)));
        }
        else{
            $generate_wallet = json_encode($generate_wallet->response);
            $generate_wallet = json_decode($generate_wallet,true);
            if(isset($generate_wallet['success']) && $generate_wallet['success']==true){
                $wallet = array("id"=>$generate_wallet['wallet_id'],"keys"=>$generate_wallet['keys'],"confirmedBalance"=>$generate_wallet['balance'],"label"=>$generate_wallet['category'],"receiveAddress"=>$generate_wallet['address']);
                return $wallet;
            }
            else{
                throw new BlockchainException(__(json_encode($generate_wallet)));
            }
        }
    }


    public function sendMultiple($wallet, $outputs)
    {
        // $this->express->walletId = $wallet->wallet_id;

        // $num_blocks = (int) config()->get('settings.tx_num_blocks');

        // $result = $this->express->sendTransactionToMany(
        //     $outputs, $wallet->passphrase, null, $num_blocks
        // );

        // if (!$result) {
        //     throw new BlockchainException(__('Unable to connect to blockchain network!'));
        // }

        // if (isset($result['error'])){
        //     throw new BlockchainException($result['error']);
        // }

        // $transfer = $result['transfer'];

        // $this->updateOutputBalance($outputs);

        // $this->updateInputBalance($wallet, $transfer);

        // $this->storeTransaction($wallet, $transfer);
        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        $txt1 = json_encode($wallet);
        $txt2 = json_encode($outputs);
        fwrite($myfile, $txt1.$txt2);
        return false;
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
