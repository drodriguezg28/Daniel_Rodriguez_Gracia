<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class telefono extends Model
{
    protected $table = 'telefono';
    protected $primaryKey = 'ID_Telefono';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Un teléfono puede pertenecer a varios ojeadores (N a M)
    public function ojeadores()
    {
        return $this->belongsToMany(ojeadores::class, 'telefono_ojeador', 'ID_Telefono', 'ID_Ojeador');
    }

    // Un teléfono puede pertenecer a varios clubes (N a M)
    public function clubes()
    {
        return $this->belongsToMany(clubes::class, 'telefono_club', 'ID_Telefono', 'ID_Club');
    }

    // Un teléfono puede pertenecer a varios agentes (N a M)
    public function agentes()
    {
        return $this->belongsToMany(agentes::class, 'telefono_agente', 'ID_Telefono', 'ID_Agente');
    }
}