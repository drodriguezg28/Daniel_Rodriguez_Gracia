<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class jugadores extends Model
{
    protected $table = 'jugadores';
    protected $primaryKey = 'ID_Jugador';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Un jugador tiene muchas estadísticas
    public function estadisticas() {
        return $this->hasMany(estadisticas_jugador::class, 'Jugador', 'ID_Jugador');
    }

    // Un jugador tiene muchos informes de scouting
    public function informes() {
        return $this->hasMany(informes_scouting::class, 'Jugador', 'ID_Jugador');
    }

    // Un jugador firma muchos contratos de representación a lo largo de su carrera
    public function contratos() {
        return $this->hasMany(contratos_representacion::class, 'Jugador', 'ID_Jugador');
    }

    // Un jugador ha participado en varias temporadas (N a M)
    public function temporadas() {
        return $this->belongsToMany(temporada::class, 'temporada_jugador', 'ID_Jugador', 'ID_Temporada');
    }

    // Un jugador pertenece actualmente a un club
    public function club() {
        return $this->belongsTo(clubes::class, 'Club_Actual', 'ID_Club'); 
    }

    public function agente()
    {
        
        return $this->belongsTo(agentes::class, 'Agente', 'ID_Agente');
    }

    public function pais()
    {
        return $this->belongsTo(paises::class, 'Nacionalidad', 'ID_Pais'); 
    }
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'Usuario', 'id');
    }

    public function getFotoPerfilAttribute($value)
    {
        // 1. Definimos la ruta de la imagen por defecto
        $default = 'img/jugador_default.png'; 

        
        if (empty($value)) {
            return asset($default);
        }
        if (@getimagesize($value) === false) {
            return asset($default);
        }


        return asset($value);
    }
}