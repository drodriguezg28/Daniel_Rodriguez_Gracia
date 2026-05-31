USE elitescouting;

SET FOREIGN_KEY_CHECKS = 0;

-- 22. USUARIOS (Tabla de Laravel)
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/usuarios.csv'
INTO TABLE users
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(name, email, password, tipo_usuario);

SET FOREIGN_KEY_CHECKS = 1;