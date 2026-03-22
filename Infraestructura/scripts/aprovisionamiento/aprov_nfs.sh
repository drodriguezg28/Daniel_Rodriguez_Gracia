#!/bin/bash

#!/bin/bash

# Instalación de NFS
sudo apt update -qq
sudo apt install nfs-kernel-server php8.2-fpm php8.2-mysql -y -qq
echo "NFS se ha instalado correctamente y está activo."

# Crear el directorio para compartir vía NFS
sudo mkdir -p /var/www/php

#configurar NFS para compartir el directorio /var/www/html
echo "/var/www/php    192.168.20.10(rw,sync,no_subtree_check)" | sudo tee -a /etc/exports
echo "/var/www/php    192.168.20.11(rw,sync,no_subtree_check)" | sudo tee -a /etc/exports
sudo exportfs -a
sudo systemctl restart nfs-kernel-server
echo "NFS se ha configurado para compartir el directorio /var/www/html."

# Inhabilitar la red NAT
# ip route del default
echo "Salida de la red NAT inhabilitada."