<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contratos_representacion extends Model
{
    protected $table = 'contratos_representacion';
    protected $primaryKey = 'ID_Contrato';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Este contrato pertenece a un agente
    public function agente() {
        return $this->belongsTo(agentes::class, 'Agente', 'ID_Agente');
    }

    // Este contrato pertenece a un jugador
    public function jugador() {
        return $this->belongsTo(jugadores::class, 'Jugador', 'ID_Jugador');
    }
}
