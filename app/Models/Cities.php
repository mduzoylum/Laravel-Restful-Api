<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cities extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'cities';
    protected $fillable = ['city_name'];
    public $timestamps=false;

    public function scopeSearchCity($query,Request $request)
    {
        return $query->where('city_name', 'LIKE', '%' . $request->input("q") . '%');
    }
}
