<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = 'revisiones';          
    protected $fillable = ['orden_id','rubro','revision_1','revision_2','revision_3'];

    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }
}
