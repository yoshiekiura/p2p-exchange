<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KomodoTransaction extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * Get user wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo('App\Models\KomodoWallet', 'wallet_id', 'id');
    }

}
