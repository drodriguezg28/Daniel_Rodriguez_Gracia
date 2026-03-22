CREATE DATABASE IF NOT EXISTS elitescouting;

CREATE USER IF NOT EXISTS 'admin'@'192.168.30.%' IDENTIFIED BY 'admincontra';
CREATE USER IF NOT EXISTS 'director'@'192.168.30.%' IDENTIFIED BY 'directorcontra';
CREATE USER IF NOT EXISTS 'ojeadores'@'192.168.30.%' IDENTIFIED BY 'ojeadorcontra';
CREATE USER IF NOT EXISTS 'agentes'@'192.168.30.%' IDENTIFIED BY 'agentecontra';

GRANT ALL PRIVILEGES ON elitescouting.* TO 'admin'@'192.168.30.%';
GRANT ALL PRIVILEGES ON elitescouting.* TO 'director'@'192.168.30.%';
GRANT UPDATE, INSERT, DELETE, SELECT ON elitescouting.* TO 'ojeadores'@'192.168.30.%';
GRANT UPDATE, SELECT, DELETE ON elitescouting.* TO 'agentes'@'192.168.30.%';
FLUSH PRIVILEGES;