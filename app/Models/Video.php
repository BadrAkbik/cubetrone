<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'watchables';

    protected $guarded = [];


    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
