<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class contrataciones extends Model
{
    protected $table = 'contrataciones';
    protected $primaryKey = 'ID_Contratacion';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // La contratación implica a un jugador
    public function jugador() {
        return $this->belongsTo(jugadores::class, 'Jugador', 'ID_Jugador');
    }

    // La contratación es realizada por un club
    public function club() {
        return $this->belongsTo(clubes::class, 'Club', 'ID_Club');
    }
}