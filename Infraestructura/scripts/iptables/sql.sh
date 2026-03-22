#!/bin/bash

####################################
#Configuracion de las IPTABLES #####
####################################

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

#Permitir SSH
iptables -A INPUT -p tcp --dport 22 -j ACCEPT

#Permite SSH solo desde la red interna de la base de datos.
iptables -A INPUT -p tcp -s 192.168.30.0/24 --dport 22 -j ACCEPT

#Permitir respuesta de conexiones establecidas
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT
echo "Paquetes de respuesta permitidos."

#Permite que los paquetes enviados por el sql sean aceptados.
iptables -A INPUT -p tcp -s 192.168.30.0/24 --dport 3306 -j ACCEPT

#Cada intento de conexión bloqueado se registra en los logs del sistema (4 = Warning).
iptables -A INPUT -m limit --limit 20/min -j LOG --log-prefix "IPTABLES BLOQUEADO: " --log-level 4

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
