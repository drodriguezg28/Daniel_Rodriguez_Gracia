<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class competicion extends Model
{
    protected $table = 'competicion';
    protected $primaryKey = 'ID_Competicion';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Una competición tiene muchos clubes participando en ella (N a M)
    public function clubes() {
        return $this->belongsToMany(clubes::class, 'competi_clubes', 'ID_Competicion', 'ID_Club');
    }

    // Una competición tiene muchas estadísticas registradas
    public function estadisticas() {
        return $this->hasMany(estadisticas_jugador::class, 'Competicion', 'ID_Competicion');
    }

    // Una competición pertenece a un país
    public function pais() {
        return $this->belongsTo(paises::class, 'Pais', 'ID_Pais');
    }
}