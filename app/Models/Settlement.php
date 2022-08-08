<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Settlement extends Model
{
    use HasFactory;

    protected $fillable = ['key','name','zone_type', 'type_id'];
    protected $hidden   = [ 'pivot', 'type_id'];
    public $timestamps  = false;
    protected $primaryKey = 'key';
    //protected $keyType = 'string';

    public function settlement_type()
    {
        return $this->belongsTo(SettlementType::class, 'type_id');
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                $replace= ['á'=>'a', 'é'=>'e','í'=>'i','ó'=>'o', 'ú'=>'u', 'Á'=>'a', 'É'=>'e','Í'=>'i','Ó'=>'o', 'Ú'=>'u', 'ñ' => '?', 'ü' => '?', '°'=> '?'];
                return strtoupper(str_replace(array_keys($replace), array_values($replace), strtolower($value)));
            }
        );
    }

    public function zoneType(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                $replace= ['á'=>'a', 'é'=>'e','í'=>'i','ó'=>'o', 'ú'=>'u', 'Á'=>'a', 'É'=>'e','Í'=>'i','Ó'=>'o', 'Ú'=>'u'];
                return strtoupper(str_replace(array_keys($replace), array_values($replace), strtolower($value)));
            }
        );
    }
}
