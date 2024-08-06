<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Statement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'statements';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'number',
        'category',
        'title',
        'state',
        'content',
        'date',
        'file',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date:Y-m-d'
        ];
    }

    protected $dates = ['date'];

    public function setDateAttribute(string $value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function getDateAttribute(): string
    {
        return Carbon::parse($this->attributes['date'])->format('Y-m-d');
    }

    public function getCreatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
