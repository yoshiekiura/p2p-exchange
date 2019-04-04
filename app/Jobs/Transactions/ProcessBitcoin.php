<?php

namespace App\Jobs\Transactions;

use App\Logics\Hosted\Adapters\BitcoinAdapter;
use App\Models\BitcoinAddress;
use App\Models\BitcoinTransaction;
use App\Models\BitcoinWallet;
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

class ProcessBitcoin implements ShouldQueue
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
    // public function handle(BitcoinAdapter $adapter)
    // {
    //     $adapter->express->walletId = $this->data['wallet'];

    //     $wallet = BitcoinWallet::where('wallet_id', $this->data['wallet'])->first();

    //     if (!$wallet) return;

    //     $tx = $adapter->express->getWalletTransfer($this->data['hash']);

    //     if (!$tx) {
    //         throw new \Exception(__('Unable to connect to blockchain network!'));
    //     }

    //     if (isset($tx['error'])) {
    //         throw new \Exception($tx['error']);
    //     }

    //     $confirmations = (int) $tx['confirmations'] ?? 0;

    //     $transaction = $wallet->transactions()
    //         ->where('hash', $this->data['hash'])
    //         ->first();

    //     if ($tx['type'] == 'send') {
    //         if(!$transaction){
    //             $transaction = $wallet->transactions()->create([
    //                 'type'           => $tx['type'],
    //                 'hash'           => $tx['txid'],
    //                 'confirmations'  => $confirmations,
    //                 'transaction_id' => $tx['id'],
    //                 'state'          => $tx['state'],
    //                 'date'           => Carbon::parse($tx['date']),
    //                 'value'          => $tx['value'],
    //             ]);
    //         }

    //         if ($confirmations >= 1) {
    //             $result = $adapter->express->getWallet();

    //             if (!$result) {
    //                 throw new \Exception(__('Unable to connect to blockchain network!'));
    //             }

    //             if (isset($result['error'])) {
    //                 throw new \Exception($result['error']);
    //             }

    //             $wallet->update([
    //                 'balance' => $result['confirmedBalance']
    //             ]);
    //         }
    //     }

        // if ($tx['type'] == 'receive') {
        //     $min_confirmations = (int) $this->settings['min_tx_confirmations'];

        //     if ($transaction) {
        //         if ($confirmations >= $min_confirmations) {
        //             if ($user = $wallet->user) {
        //                 $user->notify(new IncomingConfirmed('btc', $tx['value']));
        //             }

        //             $result = $adapter->express->getWallet();

        //             if (!$result) {
        //                 throw new \Exception(__('Unable to connect to blockchain network!'));
        //             }

        //             if (isset($result['error'])) {
        //                 throw new \Exception($result['error']);
        //             }

        //             $wallet->update(['balance' => $result['confirmedBalance']]);
        //         }
        //     } else {
        //         $transaction = $wallet->transactions()->create([
        //             'type'           => $tx['type'],
        //             'hash'           => $tx['txid'],
        //             'confirmations'  => $confirmations,
        //             'transaction_id' => $tx['id'],
        //             'state'          => $tx['state'],
        //             'date'           => Carbon::parse($tx['date']),
        //             'value'          => $tx['value'],
        //         ]);

        //         if ($confirmations < $min_confirmations) {
        //             if ($user = $wallet->user) {
        //                 $user->notify(new IncomingUnconfirmed('btc', $tx['value']));
        //             }
        //         }
        //     }
        // }

    //     if ($transaction) {
    //         $transaction->update([
    //             'confirmations' => $confirmations,
    //             'state'         => $tx['state'],
    //         ]);
    //     }
    // }

    public function handle(BitcoinAdapter $adapter)
    {
        if(isset($this->data['wallet_id'],$this->data['tx_type'],$this->data['confirmations'],$this->data['hash'],$this->data['value'],$this->data['id'],$this->data['state'],$this->data['balance']) && is_int($this->data['confirmations']) && is_int($this->data['balance']) && $this->data['tx_type'] == "receive"){
            $wallet = BitcoinWallet::where('wallet_id', $this->data['wallet_id'])->first();
            if (!$wallet){
                return;
            }
            else{
                $confirmations = (int) $this->data['confirmations'];
                $transaction = $wallet->transactions()->where('hash', $this->data['hash'])->first();
                $min_confirmations = (int) $this->settings['btc']['min_tx_confirmations'];
                if ($transaction) {
                    if ($confirmations >= $min_confirmations) {
                        if ($user = $wallet->user) {
                            $user->notify(new IncomingConfirmed('btc', $this->data['value']));
                        }

                        $wallet->update(['balance' => $this->data['balance']]);
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
                        'value'          => $this->data['value'],
                    ]);

                    if ($confirmations < $min_confirmations) {
                        if ($user = $wallet->user) {
                            $user->notify(new IncomingUnconfirmed('btc', $this->data['value']));
                        }
                    }
                    elseif($confirmations >= $min_confirmations){
                        $wallet->update(['balance' => $this->data['balance']]);
                        if ($user = $wallet->user) {
                            $user->notify(new IncomingConfirmed('btc', $this->data['value']));
                        } 
                    }
                }
            }
        }
        else{
            echo json_encode(["success"=>false,'message'=>'invalid request']);
            return;
        }
    }

}
