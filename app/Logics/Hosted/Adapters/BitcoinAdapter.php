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

use App\Logics\Hosted\Adapters\Traits\Adapter;
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
        for ($i=0; $i < sizeof($outputs); $i++) { 
            $addresses[] = $outputs[$i]['address'];
            $amounts[] = $outputs[$i]['amount'];
        }
        $send_multiple = new Curl();
        $send_multiple->setHeader("Authorization",$this->accesstoken);
        $api_url = $this->api_url;
        $send_multiple->post($api_url.'transaction',array('coin'=>'BTC','userid'=>$wallet->user_id,'wallet_id'=>$wallet->wallet_id,'wallet_key'=>$wallet->passphrase,'addresses'=>$addresses,'amounts' =>$amounts));
        if($send_multiple->errorMessage){
            throw new BlockchainException(__('Unable to connect to blockchain network!'));
            //throw new BlockchainException(__(json_encode($send_multiple->response)));
        }else{
            $send_multiple = json_encode($send_multiple->response);
            $send_multiple = json_decode($send_multiple,true);
            if(isset($send_multiple['success']) && $send_multiple['success']==true){
                $this->updateOutputBalance($outputs);
                $this->updateInputBalance($wallet, $send_multiple);
                $this->storeTransaction($wallet, $send_multiple);
                return $send_multiple;
            }
            elseif (isset($send_multiple['success']) && $send_multiple['success']==false) {
                throw new BlockchainException(__($send_multiple['message']));
            }
            else{
                throw new BlockchainException(__(json_encode($send_multiple)));
            }
        }
        // $num_blocks = (int) config()->get('settings.tx_num_blocks');
    }

    public function send($wallet, $output, $amount)
    {
        if ($amount < 0) {
            throw new BlockchainException(__('Invalid Request'));
        } else {
            $send_tx = new Curl();
            $send_tx->setHeader("Authorization",$this->accesstoken);
            $api_url = $this->api_url;
            $send_tx->post($api_url.'withdraw',array('coin'=>'BTC','userid'=>$wallet->user_id,'wallet_id'=>$wallet->wallet_id,'wallet_key'=>$wallet->passphrase,'address'=>$output,'amount'=>$amount));
            if($send_tx->errorMessage){
                //throw new BlockchainException(__('Unable to generate wallet'));
                throw new BlockchainException(__(json_encode($send_tx->response)));
            }else{
                $send_tx = json_encode($send_tx->response);
                $send_tx = json_decode($send_tx,true);
                if(isset($send_tx['success']) && $send_tx['success']==true){
                    $this->updateOutputBalance($output,$amount);
                    $this->updateInputBalance($wallet, $send_tx);
                    $this->storeTransaction($wallet, $send_tx);
                    return $send_tx;
                }
                elseif (isset($send_tx['success']) && $send_tx['success']==false) {
                    throw new BlockchainException(__($send_tx['message']));
                }
                else{
                    throw new BlockchainException(__(json_encode($send_tx)));
                }
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

    protected function storeTransaction($wallet, $data)
    {
        return $wallet->transactions()->create([
            'type' => $data['type'],
            'hash' => $data['txid'],
            'confirmations' => $data['confirmations'] ?? 0,
            'transaction_id' => $data['id'],
            'state' => $data['state'],
            'date' => Carbon::parse(date("F j, Y, g:i a")),
            'value' => $data['value'],
        ]);
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