<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transit extends Model
{
    use HasFactory;

    public $table = 'tbl_transit_app';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [

    ];
}
