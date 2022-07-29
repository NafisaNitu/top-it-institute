<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['main_menu','menu_name','slug','status','description','position','image'];

    public function services(){
        return $this->hasMany(Service::class, 'menu_id', 'id')->approved();
    }

    public function submenus(){
        return $this->hasMany(SubMenu::class, 'menu_id', 'id');
    }

    public function scopeApproved($query){
        return $query->where('status',1);
    }


}
