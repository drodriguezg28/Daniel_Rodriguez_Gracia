#!/bin/bash


read -s -p "¿Que contraseña se le asignará al usuario root? " contraroot
read -s -p "¿Que contraseña se le asignará al usuario adminweb? " contra

sudo mysql -u root -p 'contraroot' -e "CREATE USER '$usuario'@'192.168.40.%' IDENTIFIED BY '$contra';"
sudo mysql -u root -p 'contraroot' -e "GRANT create, drop, update, insert, delete, select ON WEB.* TO 'adminweb'@'192.168.40.%';"
sudo mysql -u root -p 'contraroot' -e "FLUSH PRIVILEGES;"
echo "Base de datos y usuario '$usuario' creados con permisos asignados."
