<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['shop_name', 'comment', 'url', 'region_id', 'category_id', 'manager_id'];

    public function region(){
        return $this->belongsTo('App\Models\Region');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
}
