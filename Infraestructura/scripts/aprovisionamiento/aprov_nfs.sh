#!/bin/bash

# Instalación de NFS
sudo apt update -qq
sudo apt install nfs-kernel-server -y -qq
echo "NFS se ha instalado correctamente y está activo."

# Crear el directorio para compartir vía NFS
sudo mkdir -p /var/www/web

# Configurar NFS (evitar duplicados en /etc/exports)
if ! grep -qF "192.168.20.10" /etc/exports; then
    echo "/var/www/web    192.168.20.10(rw,sync,no_subtree_check)" | sudo tee -a /etc/exports
fi
if ! grep -qF "192.168.20.11" /etc/exports; then
    echo "/var/www/web    192.168.20.11(rw,sync,no_subtree_check)" | sudo tee -a /etc/exports
fi
sudo exportfs -a
sudo systemctl restart nfs-kernel-server
echo "NFS se ha configurado para compartir el directorio /var/www/web."
