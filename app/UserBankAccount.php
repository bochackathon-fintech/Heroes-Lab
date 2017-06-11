<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    protected $table = 'user_bank_accounts';

    protected function user()
    {
        $this->belongsTo(User::class);
    }

}
