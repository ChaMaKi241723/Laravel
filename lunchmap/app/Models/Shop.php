<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    //Categoryモデルと紐づけ
    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    //userモデルと紐づけ
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    //reviewモデルと紐づけ
    public function review() {
        return $this->belongsTo('App\Models\Review');
    }
}
