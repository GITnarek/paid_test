<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property mixed|string $color
 * @property User $user
 * @property int $taxi_id
 * @property mixed $price
 */
class UserTaxi extends Model
{
    use HasFactory;

    protected $fillable = ['color','user_id','taxi_id','price'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function original(): BelongsTo
    {
        return $this->belongsTo(Taxi::class, 'taxi_id');
    }
}
