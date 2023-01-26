<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerModel;

class CustomerCallLogsModel extends Model
{
    protected $table = 'call_logs';
    protected $fillable = ['customer_id', 'number', 'name', 'call_type', 'timestamp', 'duration'];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }
}
