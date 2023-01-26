<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerModel;

class CustomerMessagesModel extends Model
{
    protected $table = 'customers_messages';
    protected $fillable = ['customer_id', 'thread_id', 'address', 'body', 'sender', 'date'];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }
}
