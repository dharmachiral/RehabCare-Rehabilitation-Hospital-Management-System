<?php

namespace Modules\Service\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Database\factories\BafFactory;

class Baf extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'bafs';
    protected $fillable = [];
    protected $guarded = [];
    
    // protected static function newFactory(): BafFactory
    // {
    //     return BafFactory::new();
    // }
}
