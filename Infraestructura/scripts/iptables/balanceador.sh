#!/bin/bash

####################################
#Configuracion de las IPTABLES #####
####################################

#Borrar reglas previas de iptables
iptables -F
iptables -t nat -F
echo "Reglas previas de iptables borradas."

#Borrar reglas previas de iptables
iptables -F
iptables -t nat -F
echo "Reglas previas de iptables borradas."

#Politicas por defecto (Solo aceptar lo que salga (OUTPUT)).
iptables -P INPUT DROP
iptables -P FORWARD DROP
iptables -P OUTPUT ACCEPT

#Permitir loopback
iptables -A INPUT -i lo -j ACCEPT
echo "Loopback permitido."

#Permite SSH solo desde el router.
iptables -A INPUT -p tcp -s 192.168.11.5 --dport 22 -j ACCEPT
echo "SSH permitido desde la red interna n2."

#Permitir respuesta de conexiones establecidas
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT
echo "Paquetes de respuesta permitidos."

# Permitir HTTP y HTTPS desde el router
iptables -A INPUT -p tcp -s 192.168.20.5 --dport 80  -j ACCEPT
iptables -A INPUT -p tcp -s 192.168.20.5 --dport 443 -j ACCEPT
echo "Conexiones HTTP y HTTPS permitidas desde el router."

# Aceptar el redireccionamiento de puertos
sed -i '/net.ipv4.ip_forward/d' /etc/sysctl.conf
echo "net.ipv4.ip_forward = 1" >> /etc/sysctl.conf
sysctl -p

# Guardar configuración perisitentemente
# apt install iptables-persistent -y
# sleep 5
# netfilter-persistent save
# echo "Configuración de redireccionamiento de puertos completada."
# sleep 2



