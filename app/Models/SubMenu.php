<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id','name','slug','status','description','position','image'];

    public function menu(){
        return $this->hasOne(Menu::class, 'id','menu_id');
    }


    //scope
    public function scopeApproved($query){
        return $query->where('status',1);
    }

}
