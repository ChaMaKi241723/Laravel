<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    //userモデルと紐づけ
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
