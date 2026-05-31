<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estadisticas_jugador extends Model
{
    protected $table = 'estadisticas_jugador';
    protected $primaryKey = 'ID_Estadisticas';
    
    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla en no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // La estadística pertenece a un jugador
    public function jugador() {
        return $this->belongsTo(jugadores::class, 'Jugador', 'ID_Jugador');
    }

    // La estadística se hizo jugando para un club
    public function club() {
        return $this->belongsTo(clubes::class, 'Club', 'ID_Club');
    }

    // La estadística pertenece a una temporada
    public function temporada() {
        return $this->belongsTo(temporada::class, 'Temporada', 'ID_Temporada');
    }

    // La estadística pertenece a una competición (Liga, Copa...)
    public function competicion() {
        return $this->belongsTo(competicion::class, 'Competicion', 'ID_Competicion');
    }
}
