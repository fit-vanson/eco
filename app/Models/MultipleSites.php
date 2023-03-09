<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultipleSites extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'site_web',
        'is_publish',
    ];


    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }
    public function categories(){
        return $this->belongsToMany(Pro_category::class,MultipleSites_Categories::class,'multiple_site_id','category_id');
    }

    public function site_options(){
        return $this->hasOne(Site_option::class,'site_id');
    }
}
