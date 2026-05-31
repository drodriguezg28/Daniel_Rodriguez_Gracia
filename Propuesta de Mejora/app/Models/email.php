<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class email extends Model
{
    protected $table = 'email';
    protected $primaryKey = 'ID_Email';

    // Laravel asume que tienes columnas 'created_at' y 'updated_at'.
    // Como esta tabla no tiene esas columnas, se añade esta linea:
    public $timestamps = false;

    // Un email puede pertenecer a varios ojeadores (N a M)
    public function ojeadores() {
        return $this->belongsToMany(ojeadores::class, 'email_ojeador', 'ID_Email', 'ID_Ojeador');
    }

    // Un email puede pertenecer a varios clubes (N a M)
    public function clubes() {
        return $this->belongsToMany(clubes::class, 'email_club', 'ID_Email', 'ID_Club');
    }

    // Un email puede pertenecer a varios agentes (N a M)
    public function agentes() {
        return $this->belongsToMany(agentes::class, 'email_agente', 'ID_Email', 'ID_Agente');
    }
}