<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notification';
    protected $fillable = ['customer_id', 'notification'];

}
