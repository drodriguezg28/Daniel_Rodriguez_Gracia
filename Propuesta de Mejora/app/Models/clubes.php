<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clubes extends Model
{
    protected $table = 'clubes';
    protected $primaryKey = 'ID_Club';
    
    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla en no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Un club juega en varias competiciones (N a M)
    public function competiciones()
    {
        return $this->belongsToMany(competicion::class, 'competi_clubes', 'ID_Club', 'ID_Competicion');
    }

    // Un club tiene varios emails
    public function emails() {
        return $this->belongsToMany(email::class, 'email_club', 'ID_Club', 'ID_Email');
    }
    
    // Un club tiene varios teléfonos
    public function telefonos() {
        return $this->belongsToMany(telefono::class, 'telefono_club', 'ID_Club', 'ID_Telefono');
    }

    // Un club tiene muchas estadísticas asociadas
    public function estadisticas() {
        return $this->hasMany(estadisticas_jugador::class, 'Club', 'ID_Club');
    }

    public function pais()
    {
        return $this->belongsTo(paises::class, 'Pais', 'ID_Pais'); 
    }
    
    public function partidoLocal()
    {
        return $this->hasMany(partidos::class, 'Equipo_Local', 'ID_Club');
    }

    public function partidoVisitante()
    {
        return $this->hasMany(partidos::class, 'Equipo_Visitante', 'ID_Club');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Usuario', 'id');
    }
}
