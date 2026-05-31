<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class paises extends Model
{
    protected $table = 'paises';
    protected $primaryKey = 'ID_Pais';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Un país tiene muchas competiciones asociadas
    public function competiciones()
    {
        return $this->hasMany(competicion::class, 'Pais', 'ID_Pais');
    }

    // Un país es la nacionalidad de muchos agentes
    public function agentes()
    {
        return $this->hasMany(agentes::class, 'Nacionalidad', 'ID_Pais');
    }
    
    // (Opcional) Si en la tabla jugadores tienes la columna País/Nacionalidad:
    public function jugadores()
    {
        return $this->hasMany(jugadores::class, 'Nacionalidad', 'ID_Pais'); 
    }

    public function clubes() {
        return $this->hasMany(clubes::class, 'Pais', 'ID_Pais');
    }

    public function ojeadores()
    {
        return $this->hasMany(ojeadores::class, 'Nacionalidad', 'ID_Pais');
    }
}