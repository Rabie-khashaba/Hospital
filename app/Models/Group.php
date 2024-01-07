<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['name','notes'];
    public $fillable= ['Total_before_discount','discount_value','Total_after_discount','tax_rate','Total_with_tax'];

    public function service_group()
    {
        return $this->belongsToMany(Service::class,'service_groups')->withPivot('quantity');
    }

}
