<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'is_completed'];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
