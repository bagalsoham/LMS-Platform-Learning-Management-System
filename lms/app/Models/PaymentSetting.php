<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    public $timestamps = false; // optional, if your table doesn't use timestamps

    protected $fillable = ['key', 'value'];
}
