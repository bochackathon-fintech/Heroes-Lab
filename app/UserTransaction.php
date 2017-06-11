<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Transaction
 *
 * @property int $id
 * @property int $user_id
 * @property string $category
 * @property int $to_user_id
 * @property float $amount
 * @property float $balance
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereBalance($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereToUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transaction whereUserId($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $table = 'user_transactions';

    protected $guarded = [];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
