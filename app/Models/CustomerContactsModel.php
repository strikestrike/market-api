<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerModel;

class CustomerContactsModel extends Model
{
    protected $table = 'customers_contacts';
    protected $fillable = ['customer_id', 'name', 'phones'];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }
}
