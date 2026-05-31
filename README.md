<img width="313" height="839" alt="imagen" src="https://github.com/user-attachments/assets/1a8f1ceb-727a-4fcd-9b7f-5e1a43e5ea8a" /># Proyecto Intermodular

## La estructura para este repositorio es la siguiente:

```

├── Infraestructura/
│   ├── BD/
│   │   ├── datos/
│   │   ├── crearbd.sql
│   │   ├── exportar.sql
│   │   ├── FK.sql
│   │   └── Tablas.sql
│   ├── scripts/
│   │   ├── aprovisionamiento/
│   │   │   ├── aprov_balanceador.sh
│   │   │   ├── aprov_nfs.sh
│   │   │   ├── aprov_sql.sh
│   │   │   └── aprov_web.sh
│   │   ├── iptables/
│   │   │   ├── balanceador.sh
│   │   │   ├── nfs.sh
│   │   │   ├── router.sh
│   │   │   ├── sql.sh
│   │   │   └── web.sh
│   │   ├── config_ssh.sh
│   │   └── usuario_sql.sh
│   └── Vagrantfile
├── Python/
│   ├── Gestión/
│   │   ├── csv/
│   │   ├── index.py
│   │   ├── MIMODULO.py
│   │   └── Opciones.py
│   └── Logs/
│       ├── script_modif.sh
│       └── Script.py
├── Propuesta de mejora
│    ├── app/
│        ├── Controllers/ (Encargados de recibir las peticiones del usuario y devolver una respuesta)
│        ├── Livewire/
│        ├── Models/ (Corresponden a cada una de laas tablas de la Base de Datos)
│        └── Providers(Las clases que se ejecutan al arrancar la aplicación)
│    ├── config/ (Archivos de configuración)
│    ├── resources/
│        ├── css/ (estilos)
│        ├── js/
│        ├── sass/
│        └── views/ (Las vistas correspondientes a cada apartado)
│    └── routes/ (Las rutas que conectan los controladores con las vistas)
└── DocumentaciónDanielRodriguezGracia.pdf
```
Aquí están adjuntados:
- Archivos de datos para la creación y desarrollo de la Base de Datos
- Archivos de aprovisionamiento
- Archivos de asignación de reglas IPTables para cada máquina
- Aplicación Python para la gestión de credenciales y datos
- Aplicación para la gestión de Logs
- Archivos de la Propuesta de Mejora
