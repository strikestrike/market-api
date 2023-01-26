<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerModel;

class CustomerTransactionsModel extends Model
{
    protected $table = 'customer_transactions';
    protected $fillable = ['customer_id', 'transaction_id', 'identified'];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }
}
