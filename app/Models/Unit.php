<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    public $table = 'tbl_unit';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [

    ];
}
