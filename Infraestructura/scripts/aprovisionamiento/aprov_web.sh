#!/bin/bash

# Instalación de Apache, PHP y cliente NFS
sudo apt update -qq
sudo apt install apache2 php libapache2-mod-php nfs-common -y
echo "Apache, PHP y NFS cliente instalados correctamente."

# Montar NFS
sudo mkdir -p /var/www/web
echo "192.168.20.12:/var/www/web /var/www/web nfs defaults 0 0" | sudo tee -a /etc/fstab
sudo mount -a
echo "Sistema de archivos NFS montado en /var/www/web."

# Habilitar módulo PHP y reiniciar Apache
sudo a2enmod php8.2
sudo systemctl enable apache2
sudo systemctl restart apache2
echo "Apache reiniciado. La configuración está activa."

# Inhabilitar la red NAT
# ip route del default
echo "Salida de la red NAT inhabilitada."