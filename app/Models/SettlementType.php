<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name'];
    protected $hidden   = ['id'];
    public $timestamps  = false;
}
