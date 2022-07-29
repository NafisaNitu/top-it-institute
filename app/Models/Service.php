<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title','sub_title','slug','menu_id','submenu_id','status','description','image'];

    public function menu(){
        return $this->hasOne(Menu::class,'id','menu_id');
    }
    public function submenu(){
        return $this->hasOne(SubMenu::class,'id','submenu_id');
    }

    //scope
    public function scopeApproved($query){
        return $query->where('status',1);
    }
}
