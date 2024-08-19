<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propertie extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "attribute_id",
        "name",
        "code"

    ];
    public function setCreatedAtAttribute($value){

        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]= Carbon::now();

    }
    public function setUpdatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();

    }

    public function specifications(){
        return $this->hasMany(ProductSpecification::class);
    }
    public function variations(){
        return $this->hasMany(ProductVariation::class);
    }
}
