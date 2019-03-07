<?php
/**
 * ======================================================================================================
 * File Name: Adapter.php
 * ======================================================================================================
 * Author: affankhan43
 **/

namespace App\Logics\Hosted\Adapters\Traits;

use App\Models\BitcoinWallet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait Adapter
{
	/**
     * @param BitcoinWallet|LitecoinWallet|DashWallet $wallet
     * @return mixed
     */
    public function getWallet($wallet)
    {
    	$wallet_id = $wallet->wallet_id;
        return $this->express->getWallet();
    }
}
?>