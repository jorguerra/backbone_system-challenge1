<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FederalEntity extends Model
{
    use HasFactory;

    protected $fillable = ['key','name','code'];
    public $timestamps  = false;
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    protected $casts = ['key' => 'integer'];

    public function name(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                $replace= ['á'=>'a', 'é'=>'e','í'=>'i','ó'=>'o', 'ú'=>'u', 'Á'=>'a', 'É'=>'e','Í'=>'i','Ó'=>'o', 'Ú'=>'u'];
                return strtoupper(str_replace(array_keys($replace), array_values($replace), strtolower($value)));
            }
        );
    }
}
