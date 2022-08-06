<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    use HasFactory;

    protected $fillable = ['key','name','code'];
    public $timestamps  = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';
}
