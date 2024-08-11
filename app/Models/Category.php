<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "type",
        "discountPercent",
        "parentId",
    ];

    // protected $hidden = [
    //     "discountPercent"
    // ];

    protected $appends = ['isRootCa','isParentCa' , 'isItemsCa' ,'currentDiscountPercent'];

    public function getIsRootCaAttribute()
    {
        return is_null($this->parentId);

    }
    public function getIsParentCaAttribute()
    {
        return $this->type == "parentCa";
    }
    public function getIsItemsCaAttribute()
    {
        return $this->type == "itemsCa";
    }

    public function getCurrentDiscountPercentAttribute()
    {
        if (is_null($this->discountPercent))
        {
            if ($this->isRootCa)
              return $this->discountPercent;
             else
                return Category::find($this->parentId)->currentDiscountPercent;
        }
        else return $this->discountPercent;
    }
    public function parentCa()
    {
        return $this->belongsTo(Category::class,"parentId");
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class,"parentId");
    }
    public function items()
    {
        return $this->hasMany(Item::class,"categoryId");
    }
}
