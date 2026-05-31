<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class informes_scouting extends Model
{
    protected $table = 'informes_scouting';
    protected $primaryKey = 'ID_Informe';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // El informe es redactado por un ojeador
    public function ojeador() {
        return $this->belongsTo(ojeadores::class, 'Ojeador', 'ID_Ojeador'); // Asumiendo FK 'Ojeador'
    }

    // El informe analiza a un jugador específico
    public function jugador() {
        return $this->belongsTo(jugadores::class, 'Jugador', 'ID_Jugador'); // Asumiendo FK 'Jugador'
    }

    // El informe se basó en un partido cubierto concreto
    public function partido() {
        return $this->belongsTo(partidos::class, 'Partido_Cubierto', 'ID_Partido_Cubierto');
    }

}