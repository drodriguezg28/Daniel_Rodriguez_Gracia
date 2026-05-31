use App\Models\User;
use Illuminate\Support\Facades\Hash;

public function run(): void
{
    $usuarios = [
        [
            'name' => 'Admin Central',
            'email' => 'admin@proyect.com',
            'password' => Hash::make('password123'),
            'tipo_usuario' => 'admin',
        ],
        [
            'name' => 'Real Madrid CF',
            'email' => 'contacto@realmadrid.com',
            'password' => Hash::make('password123'),
            'tipo_usuario' => 'club',
        ],
        [
            'name' => 'Juan Goleador',
            'email' => 'juan@jugador.com',
            'password' => Hash::make('password123'),
            'tipo_usuario' => 'jugador',
        ],
        [
            'name' => 'Cazatalentos Pro',
            'email' => 'ojeador@scout.com',
            'password' => Hash::make('password123'),
            'tipo_usuario' => 'ojeador',
        ],
        [
            'name' => 'Jorge Agente',
            'email' => 'jorge@agencia.com',
            'password' => Hash::make('password123'),
            'tipo_usuario' => 'agente',
        ],
    ];

    foreach ($usuarios as $usuario) {
        User::create($usuario);
    }
}