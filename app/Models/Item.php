<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "price",
        "discountPercent",
        "categoryId"
    ];
    // protected $hidden = [
    //     "discountPercent"
    // ];
    public function category()
    {
        return $this->belongsTo(Category::class,"categoryId");
    }
    protected $appends = [ 'netPrice' ,'currentDiscountPercent'];

    public function getCurrentDiscountPercentAttribute()
    {
        if (is_null($this->discountPercent))
            return Category::find($this->categoryId)->currentDiscountPercent;
        else
            return $this->discountPercent;
    }

    public function getNetPriceAttribute()
    {
        $disCount=0;
        $discountPercent= $this->currentDiscountPercent;
        $price=$this->price;
        $disCount = $price*$discountPercent/100;
        return round($price - $disCount,2);
    }
}

