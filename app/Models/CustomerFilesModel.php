<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerModel;

class CustomerFilesModel extends Model
{
    protected $table = 'customers_files';
    protected $fillable = ['customer_id', 'path', 'original_filename', 'file_size'];

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class);
    }
}
