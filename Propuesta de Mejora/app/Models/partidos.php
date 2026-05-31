<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class partidos extends Model
{
    protected $table = 'partidos_cubiertos';
    protected $primaryKey = 'ID_Partido_Cubierto';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // A este partido asisten muchos ojeadores (N a M)
    public function ojeadores()
    {
        return $this->belongsToMany(ojeadores::class, 'ojeadores_partidos', 'ID_Partido_Cubierto', 'ID_Ojeador');
    }

    // En este partido participan muchos jugadores (N a M)
    public function jugadores()
    {
        return $this->belongsToMany(jugadores::class, 'partidos_jugadores', 'ID_Partido_Cubierto', 'ID_Jugador');
    }

    // De este partido salen varios informes de scouting
    public function informes()
    {
        return $this->hasMany(informes_scouting::class, 'Partido_Cubierto', 'ID_Partido_Cubierto');
    }

    public function pais()
    {
        return $this->belongsTo(paises::class, 'Pais', 'ID_Pais'); 
    }

    public function Local()
    {
        return $this->belongsTo(clubes::class, 'Equipo_Local', 'ID_Club');
    }

    public function Visitante()
    {
        return $this->belongsTo(clubes::class, 'Equipo_Visitante', 'ID_Club');
    }
}