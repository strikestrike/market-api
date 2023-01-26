<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerMessagesModel;
use App\Models\CustomerContactsModel;
use App\Models\CustomerFilesModel;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $fillable = ['secret_code', 'phone', 'active'];

    public function messages()
    {
        return $this->hasMany(CustomerMessagesModel::class, 'customer_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(CustomerContactsModel::class, 'customer_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(CustomerFilesModel::class, 'customer_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(CustomerTransactionsModel::class, 'customer_id', 'id');
    }
}
