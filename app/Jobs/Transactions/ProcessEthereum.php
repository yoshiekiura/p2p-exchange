<?php

namespace App\Jobs\Transactions;

use App\Logics\Hosted\Adapters\EthereumAdapter;
use App\Models\EthereumAddress;
use App\Models\EthereumTransaction;
use App\Models\EthereumWallet;
use App\Notifications\Transactions\IncomingConfirmed;
use App\Notifications\Transactions\IncomingUnconfirmed;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProcessEthereum implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Transaction Data
     *
     * @var array
     */
    public $data;

    /**
     * @var
     */
    protected $settings;

    /**
     * @var BitcoinAdapter
     */
    protected $helper;

    /**
     * Create a new job instance.
     *
     * @param $data
     * @return void
     */
    public function __construct($data)
    {
        $this->settings = config('settings');
        $this->data = $data;
    }

    /**
     * @param BitcoinAdapter $adapter
     * @throws \Exception
     */
    

    public function handle(EthereumAdapter $adapter)
    {
        if(isset($this->data['wallet_id'],$this->data['tx_type'],$this->data['confirmations'],$this->data['hash'],$this->data['value'],$this->data['id'],$this->data['state'],$this->data['balance']) && is_int($this->data['confirmations']) && $this->data['tx_type'] == "receive"){
            $wallet = EthereumWallet::where('wallet_id', $this->data['wallet_id'])->first();
            if (!$wallet){
                return;
            }
            else{
                $confirmations = (int) $this->data['confirmations'];
                $transaction = $wallet->transactions()->where('hash', $this->data['hash'])->first();
                $min_confirmations = (int) $this->settings['eth']['min_tx_confirmations'];
                if ($transaction) {
                    if ($confirmations >= $min_confirmations) {
                        if ($user = $wallet->user) {
                            $user->notify(new IncomingConfirmed('eth', number_format($this->data['value'],0,'','')));
                        }

                        $wallet->update(['balance' => number_format($this->data['balance'],0,'','')]);
                        $transaction->update([
                            'confirmations' => $confirmations,
                            'state'         => $this->data['state'],
                        ]);
                    }
                }
                else {
                    $transaction = $wallet->transactions()->create([
                        'type'           => $this->data['tx_type'],
                        'hash'           => $this->data['hash'],
                        'confirmations'  => $confirmations,
                        'transaction_id' => $this->data['id'],
                        'state'          => $this->data['state'],
                        'date'           => Carbon::parse(date("F j, Y, g:i a")),
                        'value'          => number_format($this->data['value'],0,'',''),
                    ]);

                    if ($confirmations < $min_confirmations) {
                        if ($user = $wallet->user) {
                            $user->notify(new IncomingUnconfirmed('eth', number_format($this->data['value'],0,'','')));
                        }
                    }
                    elseif($confirmations >= $min_confirmations){
                        $wallet->update(['balance' => number_format($this->data['balance'],0,'','')]);
                        if ($user = $wallet->user) {
                            $user->notify(new IncomingConfirmed('eth', number_format($this->data['value'],0,'','')));
                        } 
                    }
                }
            }
        }
        else{
            echo json_encode(["success"=>false,'message'=>'invalid request'.json_encode($this->data)]);
            return;
        }
    }

}
