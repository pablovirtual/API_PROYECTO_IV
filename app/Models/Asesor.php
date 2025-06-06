<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Asesor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asesores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'especialidad',
        'descripcion',
        'imagen_perfil',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the valoraciones for the asesor.
     */
    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    /**
     * Get the mensajes enviados por el asesor.
     */
    public function mensajesEnviados()
    {
        return $this->hasMany(MensajeChat::class, 'emisor_id');
    }

    /**
     * Get the mensajes recibidos por el asesor.
     */
    public function mensajesRecibidos()
    {
        return $this->hasMany(MensajeChat::class, 'receptor_id');
    }
}
