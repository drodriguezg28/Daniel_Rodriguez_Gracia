<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class transferencias extends Model
{
    protected $table = 'transferencias';
    protected $primaryKey = 'ID_Transferencia';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // En la transferencia participa un jugador
    public function jugador()
    {
        return $this->belongsTo(jugadores::class, 'Jugador', 'ID_Jugador');
    }

    // La transferencia es gestionada por un agente
    public function agente()
    {
        return $this->belongsTo(agentes::class, 'Agente', 'ID_Agente');
    }

    // El club del que sale el jugador
    public function clubOrigen()
    {
        return $this->belongsTo(clubes::class, 'Club_Origen', 'ID_Club'); // Asumiendo que la columna se llama Club_Origen
    }

    // El club al que llega el jugador
    public function clubDestino()
    {
        return $this->belongsTo(clubes::class, 'Club_Destino', 'ID_Club'); // Asumiendo que la columna se llama Club_Destino
    }
}