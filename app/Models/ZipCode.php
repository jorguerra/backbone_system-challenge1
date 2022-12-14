<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\{AsCollection, Attribute};

class ZipCode extends Model
{
    use HasFactory;

    protected $fillable = ['zip_code','locality','federal_entity_id','municipality_id'];
    protected $hidden   = ['municipality_id', 'federal_entity_id'];
    public $timestamps  = false;
    protected $primaryKey  = 'zip_code';
    protected $keyType = 'string';
    protected $cast = ['settlements' => AsCollection::class];

    public function federal_entity()
    {
        return $this->belongsTo(FederalEntity::class, 'federal_entity_id');
    }

    public function settlements()
    {
        return $this->belongsToMany(Settlement::class, 'zip_codes_has_settlements','zip_code', 'settlement');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function locality(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                $replace= ['á'=>'a', 'é'=>'e','í'=>'i','ó'=>'o', 'ú'=>'u', 'Á'=>'a', 'É'=>'e','Í'=>'i','Ó'=>'o', 'Ú'=>'u'];
                return strtoupper(str_replace(array_keys($replace), array_values($replace), strtolower($value)));
            }
        );
    }

}
