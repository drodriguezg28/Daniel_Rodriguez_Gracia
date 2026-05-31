<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class temporada extends Model
{
    protected $table = 'temporada';
    protected $primaryKey = 'ID_Temporada';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla en no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Una temporada tiene muchos jugadores que participaron en ella (N a M)
    public function jugadores()
    {
        return $this->belongsToMany(jugadores::class, 'temporada_jugador', 'ID_Temporada', 'ID_Jugador');
    }

    // Una temporada tiene muchas estadísticas registradas
    public function estadisticas()
    {
        return $this->hasMany(estadisticas_jugador::class, 'Temporada', 'ID_Temporada');
    }
}