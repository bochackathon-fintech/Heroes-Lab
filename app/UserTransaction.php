<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'user_transactions';

    protected function user()
    {
        $this->belongsTo(User::class);
    }
}
