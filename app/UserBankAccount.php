<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserBankAccount
 *
 * @property int $id
 * @property int $user_id
 * @property string $account_id
 * @property string $swift
 * @property string $iban
 * @property string $auth_provider_name
 * @property string $auth_id
 * @property string $auth_token_key
 * @property float $balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereAuthId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereAuthProviderName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereAuthTokenKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereIban($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereSwift($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserBankAccount whereUserId($value)
 * @mixin \Eloquent
 */
class UserBankAccount extends Model
{
    protected $table = 'user_bank_accounts';

    protected $guarded = [];

    public function user()
    {
        $this->belongsTo(User::class);
    }

}
