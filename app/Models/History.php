<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'actor_type',
        'actor_user_id',
        'action',
        'ref_table',
        'ref_id',
    ];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }
}
