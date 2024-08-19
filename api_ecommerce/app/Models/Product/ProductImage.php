<?php

namespace App\Models\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;
    /* SE DEFINE LOS CAMPOS  */
    protected $fillable = [
        "product_id",
        "imagen",
    ];

    public function setCreatedAtAttribute($value){

        date_default_timezone_set("America/Lima");
        $this->attributes["created_at"]= Carbon::now();

    }
    public function setUpdatedAtAttribute($value){
        date_default_timezone_set("America/Lima");
        $this->attributes["updated_at"]= Carbon::now();

    }
}
