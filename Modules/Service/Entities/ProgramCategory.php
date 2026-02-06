<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'image',
        'short_description',
        'description',
        'status'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Service\Database\factories\ProgramCategoryFactory::new();
    }
}
