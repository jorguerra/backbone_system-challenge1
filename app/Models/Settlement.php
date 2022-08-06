<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = ['key','name','zone_type', 'type_id'];
    protected $hidden   = [ 'pivot', 'type_id'];
    public $timestamps  = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';

    public function settlement_type()
    {
        return $this->belongsTo(SettlementType::class, 'type_id');
    }
}
