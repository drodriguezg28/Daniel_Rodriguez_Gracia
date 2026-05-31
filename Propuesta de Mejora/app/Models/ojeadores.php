<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ojeadores extends Model
{
    protected $table = 'ojeadores';
    protected $primaryKey = 'ID_Ojeador';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Un ojeador puede tener varios emails (N a M)
    public function emails() 
    {
        return $this->belongsToMany(email::class, 'email_ojeador', 'ID_Ojeador', 'ID_Email');
    }

    // Un ojeador puede tener varios teléfonos (N a M)
    public function telefonos() 
    {
        return $this->belongsToMany(telefono::class, 'telefono_ojeador', 'ID_Ojeador', 'ID_Telefono');
    }

    // Un ojeador redacta muchos informes de scouting
    public function informes()
    {
        return $this->hasMany(informes_scouting::class, 'Ojeador', 'ID_Ojeador');
    }

    // Un ojeador asiste a muchos partidos cubiertos (N a M)
    public function partidos() {
        return $this->belongsToMany(partidos::class, 'ojeadores_partidos', 'ID_Ojeador', 'ID_Partido_Cubierto');
    }

    // Un Ojeador tiene un unico País
    public function pais() {
        return $this->belongsTo(paises::class, 'Nacionalidad', 'ID_Pais');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Usuario', 'id');
    }
}


