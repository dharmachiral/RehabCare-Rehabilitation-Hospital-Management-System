<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'status'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Gallery\Database\factories\GalleryCategoryFactory::new();
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class,'gallerycategory_id','id');
    }
}
