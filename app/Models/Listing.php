<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title','company','location','website','email','description','tags','logo','user_id'];
    
    public function scopeFilter($query, array $filter){
        if($filter['tag'] ?? false)
        {
            $query->where('tags','like','%' . request('tag') . '%');
        }

        if($filter['search'] ?? false)
        {
            $query->where('title','like','%' . request('search') . '%')
            ->orWhere('description','like','%' . request('search') . '%')
            ->orWhere('tags','like','%' . request('search') . '%');
        }
    }


    //Relationdhip To User
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
