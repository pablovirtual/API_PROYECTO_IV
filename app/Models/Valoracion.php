<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asesor;

class Valoracion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asesor_id',
        'calificacion',
        'comentario',
    ];

    /**
     * Get the asesor that owns the valoracion.
     */
    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }
}
