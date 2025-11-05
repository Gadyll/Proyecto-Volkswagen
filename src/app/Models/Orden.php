<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';             
    protected $fillable = ['numero_orden','numero_chasis','fecha','observaciones','asesor_id'];

    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }

    public function revisiones()
    {
        return $this->hasMany(Revision::class);
    }
}
