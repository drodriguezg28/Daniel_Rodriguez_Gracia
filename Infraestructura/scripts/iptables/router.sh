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
echo "Loopback permitido."

#Permitir SSH
iptables -A INPUT -p tcp --dport 22 -j ACCEPT

#Permitir respuesta de conexiones establecidas
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
iptables -A FORWARD -m state --state ESTABLISHED,RELATED -j ACCEPT
echo "Paquetes de respuesta permitidos."

# Redireccion el puerto 443 hacia el balanceador web
iptables -t nat -A PREROUTING -p tcp --dport 443 -j DNAT --to-destination 192.168.11.10:443
iptables -A FORWARD -p tcp -d 192.168.11.10 --dport 443 -j ACCEPT
iptables -t nat -A POSTROUTING -p tcp -d 192.168.11.10 --dport 443 -j MASQUERADE
echo "Redireccionamiento del puerto 443 realizado."

# Redireccion el puerto 80 hacia el balanceador web
iptables -t nat -A PREROUTING -p tcp --dport 80 -j DNAT --to-destination 192.168.11.10:80
iptables -A FORWARD -p tcp -d 192.168.11.10 --dport 80 -j ACCEPT
iptables -t nat -A POSTROUTING -p tcp -d 192.168.11.10 --dport 80 -j MASQUERADE
echo "Redireccionamiento del puerto 80 realizado."

# Redireccion el puerto 53 hacia el servidor DNS
iptables -t nat -A PREROUTING -p tcp --dport 53 -j DNAT --to-destination 192.168.10.10:53
iptables -A FORWARD -p tcp -d 192.168.10.10 --dport 53 -j ACCEPT
echo "Redireccionamiento del puerto 53 realizado."

# Redireccion el puerto 21 (control/acciones cliente) y del 30000 al 31000 (Datos) hacia el servidor FTP
iptables -t nat -A PREROUTING -p tcp --dport 21 -j DNAT --to-destination 192.168.10.11:21
iptables -t nat -A PREROUTING -p tcp --dport 30000:31000 -j DNAT --to-destination 192.168.10.11:30000-31000

iptables -t nat -A POSTROUTING -p tcp -d 192.168.10.11 --dport 21 -j MASQUERADE
iptables -t nat -A POSTROUTING -p tcp -d 192.168.10.11 --dport 30000:31000 -j MASQUERADE
echo "Redireccionamiento del puerto 21 y del 30000 al 31000 realizado."

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