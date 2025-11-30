<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Promotion
 * 
 * @property int $promotion_id
 * @property string|null $code
 * @property string|null $description
 * @property float|null $discount_percent
 * @property Carbon|null $valid_from
 * @property Carbon|null $valid_to
 * @property bool|null $is_active
 *
 * @package App\Models
 */
class Promotion extends Model
{
    protected $primaryKey = 'promotion_id';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'description',
        'discount_percent',
        'valid_from',
        'valid_to',
        'is_active'
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_to'   => 'date'
    ];
}


