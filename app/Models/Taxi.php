<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $key
 * @property mixed $price
 * @property int $id
 */
class Taxi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'key', 'price',
    ];
}
