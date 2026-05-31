CREATE DATABASE IF NOT EXISTS elitescouting;

CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY 'admincontra';
CREATE USER IF NOT EXISTS 'director'@'%' IDENTIFIED BY 'directorcontra';
CREATE USER IF NOT EXISTS 'ojeadores'@'%' IDENTIFIED BY 'ojeadorcontra';
CREATE USER IF NOT EXISTS 'agentes'@'%' IDENTIFIED BY 'agentecontra';

GRANT ALL PRIVILEGES ON elitescouting.* TO 'admin'@'%';
GRANT ALL PRIVILEGES ON elitescouting.* TO 'director'@'%';
GRANT UPDATE, INSERT, DELETE, SELECT ON elitescouting.* TO 'ojeadores'@'%';
GRANT UPDATE, SELECT, DELETE ON elitescouting.* TO 'agentes'@'%';
FLUSH PRIVILEGES;