<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use Concerns\HasCreated, Concerns\HasUpdated;
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function column()
    {
        return $this->belongsTo(SpaceColumn::class);
    }
}
