<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class agentes extends Model
{
    protected $table = 'agentes';
    protected $primaryKey = 'ID_Agente';
    
    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla en no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    protected $fillable = [
        'Nombre', 
        'Apellido1', 
        'Apellido2', 
        'Apodo', 
        'Nacionalidad'
    ];


    // Un agente tiene muchos contratos
    public function contratos() {
        return $this->hasMany(contratos_representacion::class, 'Agente', 'ID_Agente');
    }

    // Un agente tiene varios emails (N a M usando la tabla 'email_agentes')
    public function emails() {
        return $this->belongsToMany(email::class, 'email_agente', 'ID_Agente', 'ID_Email');
    }
    
    // Un agente tiene varios teléfonos
    public function telefonos() {
        return $this->belongsToMany(telefono::class, 'telefono_agente', 'ID_Agente', 'ID_Telefono');
    }
    public function pais()
    {
        return $this->belongsTo(paises::class, 'Nacionalidad', 'ID_Pais'); 
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'Usuario', 'id');
    }
}
