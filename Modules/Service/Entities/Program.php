<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'icon',
        'shortdescription',
        'description',
        'image',
        'video',
        'status',
        'program_type',
        'date',
        'end_date',
        'location',
        'partner_id',
    ];
    public function category()
    {
        return $this->hasOne(ProgramCategory::class,'id','category_id');
    } 
    public function partner()
    {
        return $this->hasOne(ProgramCategory::class,'id','partner_id');
    } 
    protected static function newFactory()
    {
        return \Modules\Service\Database\factories\ProgramFactory::new();
    }
}
