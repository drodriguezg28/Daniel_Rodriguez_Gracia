#!/bin/bash

# Configuración de SSH para acceder al balanceador desde el router
cp /vagrant/.vagrant/machines/balanceador/virtualbox/private_key /home/vagrant/.ssh/balanceador_key
chmod 600 /home/vagrant/.ssh/balanceador_key
cat <<EOF >> ~/.ssh/config
    Host balanceador 192.168.11.10
    HostName 192.168.11.10
    User vagrant
    IdentityFile ~/.ssh/balanceador_key
EOF
echo "Configuración SSH para el balanceador completada."
#conexión SSH al balanceador
ssh balanceador
echo "Conexión SSH al balanceador establecida."

# Configuración de SSH para acceder al servidor web 1 desde el balanceador
cp /vagrant/.vagrant/machines/servidorweb1/virtualbox/private_key /home/vagrant/.ssh/serverweb1_key
chmod 600 /home/vagrant/.ssh/serverweb1_key
echo "Configuración SSH para el servidor web 1 completada."

# Configuración de SSH para acceder al servidor web 2 desde el balanceador
cp /vagrant/.vagrant/machines/servidorweb2/virtualbox/private_key /home/vagrant/.ssh/serverweb2_key
chmod 600 /home/vagrant/.ssh/serverweb2_key
echo "Configuración SSH para el servidor web 2 completada."

# Configuración de SSH para acceder al servidor NFS desde el balanceador
cp /vagrant/.vagrant/machines/nfs/virtualbox/private_key /home/vagrant/.ssh/nfs_key
chmod 600 /home/vagrant/.ssh/nfs_key
echo "Configuración SSH para el servidor NFS completada."

cat <<EOF >> ~/.ssh/config
    Host servidorweb1 192.168.20.10
    HostName 192.168.20.10
    User vagrant
    IdentityFile ~/.ssh/serverweb1_key

    Host servidorweb2 192.168.20.11
    HostName 192.168.20.11
    User vagrant
    IdentityFile ~/.ssh/serverweb2_key

    Host nfs 192.168.20.20
    HostName 192.168.20.20
    User vagrant
    IdentityFile ~/.ssh/nfs_key
EOF

#conexión SSH al servidor NFS
ssh -i .ssh/nfs_key vagrant@192.168.30.20
echo "Conexión SSH al servidor NFS establecida."

cp /vagrant/.vagrant/machines/sql/virtualbox/private_key /home/vagrant/.ssh/sql_key
chmod 600 /home/vagrant/.ssh/sql_key

cat <<EOF >> ~/.ssh/config
Host sql 192.168.30.5
    HostName 192.168.30.5
    User vagrant
    IdentityFile ~/.ssh/sql_key
EOF

echo "Configuración SSH para el servidor SQL completada."
