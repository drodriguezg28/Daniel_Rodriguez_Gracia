# Proyecto Intermodular

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
└── DocumentaciónDanielRodriguezGracia.pdf
```
Aquí están adjuntados:
- Archivos de datos para la creación y desarrollo de la Base de Datos
- Archivos de aprovisionamiento
- Archivos de asignación de reglas IPTables para cada máquina
- Aplicación Python para la gestión de credenciales y datos
- Aplicación para la gestión de Logs
