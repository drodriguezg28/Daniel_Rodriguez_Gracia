#!/bin/bash


# Instalación de Apache, PHP y cliente NFS
sudo apt update -qq
sudo apt install apache2 php8.2 libapache2-mod-php8.2 php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-bcmath mariadb-client nfs-common -y
echo "Apache, PHP y NFS cliente instalados correctamente."

# Montar NFS
sudo mkdir -p /var/www/web

# Eliminar entrada previa si existe para evitar duplicados y actualizar parámetros
sudo sed -i '/192.168.20.12:\/var\/www\/web/d' /etc/fstab

# Añadir la entrada con x-systemd.automount y nfsvers=4 para solucionar el problema con iptables
echo "192.168.20.12:/var/www/web /var/www/web nfs nfsvers=4,defaults,nofail,_netdev,x-systemd.automount 0 0" | sudo tee -a /etc/fstab

# Recargar systemd para que lea el nuevo fstab e intente montar
sudo systemctl daemon-reload
sudo mount -a 2>/dev/null || echo "NFS no disponible aún, se montará automáticamente al acceder al directorio."
echo "Sistema de archivos NFS configurado en /var/www/web."

# Configurar Apache para Laravel (DocumentRoot y mod_rewrite)
sudo sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/web/public|g' /etc/apache2/sites-available/000-default.conf
# Solución al problema del enrutamiento de Laravel: reemplazar "AllowOverride None" por "All" correctamente
sudo sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
sudo a2enmod rewrite

# Habilitar módulo PHP y reiniciar Apache
sudo a2enmod php8.2
sudo systemctl enable apache2
sudo systemctl restart apache2
echo "Apache reiniciado. La configuración está activa."

