<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Asesor;

class MensajeChat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'mensaje',
        'leido',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'leido' => 'boolean',
    ];

    /**
     * Get the emisor that owns the mensaje.
     */
    public function emisor()
    {
        return $this->belongsTo(Asesor::class, 'emisor_id');
    }

    /**
     * Get the receptor that owns the mensaje.
     */
    public function receptor()
    {
        return $this->belongsTo(Asesor::class, 'receptor_id');
    }
}
