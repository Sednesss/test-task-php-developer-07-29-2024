<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
