<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель смены.
 */
class Shift extends Model
{
    protected $fillable = [
        'user_id',
        'time_start',
        'time_end',
        'is_open',
    ];

    public $timestamps = false;

    /**
     * Отношение смены к пользователю.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
