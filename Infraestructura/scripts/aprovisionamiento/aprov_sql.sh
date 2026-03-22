#!/bin/bash

set -e

DB_NAME="elitescouting"
DB_ROOT_PASS="123456789"
SQL_DIR="/vagrant/BD"

# Instalar MariaDB
sudo apt update -qq
export DEBIAN_FRONTEND=noninteractive
sudo apt install mariadb-server mariadb-client -y
echo "MariaDB se ha instalado correctamente."

# COnfigurar MariaDB
sudo systemctl start mariadb
sudo systemctl enable mariadb
sudo sed -i "s|bind-address\s*=.*|bind-address = 0.0.0.0|g" /etc/mysql/mariadb.conf.d/50-server.cnf
cat > /etc/mysql/mariadb.conf.d/99-proyecto.cnf << EOF
[mysqld]
secure_file_priv     = ""
local_infile         = 1
character-set-server = utf8mb4
collation-server     = utf8mb4_unicode_ci
 
[mysql]
local-infile         = 1
EOF

systemctl restart mariadb

echo "Servicio de MariaDB iniciado y configurado"

for i in $(seq 1 30); do
    if mysqladmin ping --socket=/run/mysqld/mysqld.sock --silent 2>/dev/null; then
        break
    fi
    sleep 1
done
 
# Contraseña root
mysql --socket=/run/mysqld/mysqld.sock -e "
ALTER USER 'root'@'localhost' IDENTIFIED VIA mysql_native_password USING PASSWORD('${DB_ROOT_PASS}');
DELETE FROM mysql.user WHERE User='';
DROP DATABASE IF EXISTS test;
FLUSH PRIVILEGES;
"


# Configurar la base de datos y el usuario
echo "Creando BD y usuarios"
mysql -u root -p"${DB_ROOT_PASS}" --abort-source-on-error < "${SQL_DIR}/crearbd.sql"
echo "Base de datos elitescouting y usuario admin creados con los permisos adecuados."
 
# Crear las tablas
echo "Creando Tablas"
mysql -u root -p"${DB_ROOT_PASS}" --abort-source-on-error "${DB_NAME}" < "${SQL_DIR}/Tablas.sql"
echo "Creación de tablas realizada"
 
# Añadir claves foráneas
echo "Creando las claves foraneas"
mysql -u root -p"${DB_ROOT_PASS}" --abort-source-on-error "${DB_NAME}" < "${SQL_DIR}/FK.sql"
echo "Creación de claves foraneas realizada"
 
# 4. Inserts estáticos (si los hay)
echo "Insertando de datos"
mysql -u root -p"${DB_ROOT_PASS}" --local-infile=1 "${DB_NAME}" < "${SQL_DIR}/exportar.sql"
echo "Inserción de datos realizada"



echo "Creación y configuracion de la base de datos realizada"

# Inhabilitar la red NAT
# ip route del default
echo "Salida de la red NAT inhabilitada."

