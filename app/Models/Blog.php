<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','sub_title','type','category_id','tag_id','description','status','image'];


    public function scopeApproved($query){
        return $query->where('status',1);
    }


}
