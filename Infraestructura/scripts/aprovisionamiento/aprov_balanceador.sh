#!/bin/bash

# Instalación de Apache
sudo apt update -qq
echo "Repositorios actualizados."

sudo apt install apache2 -y
echo "Apache instalado correctamente."

# Habilitar módulos necesarios para el balanceo de carga
sudo a2enmod proxy
sudo a2enmod proxy_http
sudo a2enmod proxy_balancer
sudo a2enmod lbmethod_byrequests
echo "Módulos de proxy y balanceo habilitados."

# Configuración del balanceador de carga
cat <<'EOF' > /etc/apache2/sites-available/balanceador.conf
<VirtualHost *:80>

    <Proxy balancer://backend_servers>
        BalancerMember http://192.168.20.10:80
        BalancerMember http://192.168.20.11:80
        ProxySet lbmethod=byrequests
    </Proxy>

    ProxyPreserveHost On
    ProxyPass        / balancer://backend_servers/
    ProxyPassReverse / balancer://backend_servers/

</VirtualHost>
EOF
echo "Archivo de configuración del balanceador creado."

# Habilitar el nuevo sitio y deshabilitar el sitio por defecto
sudo a2ensite balanceador.conf
sudo a2dissite 000-default.conf
echo "Sitio balanceador habilitado y sitio por defecto deshabilitado."

# Habilitar y recargar Apache
sudo systemctl enable apache2
sudo systemctl reload apache2
echo "Balanceador de carga configurado y activo."

# Inhabilitar la red NAT
# ip route del default
echo "Salida de la red NAT inhabilitada."