<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'deadline',
        'progress',
    ];

    // Relation: a Goal belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
    return $this->hasMany(Step::class);
    }

    public function updateProgress()
    {
      $totalSteps = $this->steps()->count();
      $completedSteps = $this->steps()->where('is_completed', true)->count();

       if ($totalSteps > 0) {
         $this->progress = round(($completedSteps / $totalSteps) * 100);
       }   else {
          $this->progress = 0;
       }

      $this->save();
   }


}
