<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'image',
        'gallerycategory_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Gallery\Database\factories\GalleryFactory::new();
    }

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class,'gallerycategory_id','id');
    }
}
