
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = '';

-- 1. PAISES  (separador ;)
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/paises.csv'
INTO TABLE paises
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Pais, Continente);
  
-- 2. EMAIL
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/email.csv'
INTO TABLE email
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Email, Email);
  
-- 3. TELEFONO
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/telefono.csv'
INTO TABLE telefono
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Telefono, Telefono);

-- 4. AGENTES
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/Agentes.csv'
INTO TABLE agentes
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Nombre, Apellido1, Apellido2, Nacionalidad, Email, Telefono);
  
-- 5. CLUBES
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/Clubes.csv'
INTO TABLE clubes
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Nombre, Telefono, Email, url_logo);
  
-- 6. OJEADORES
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/Ojeadores.csv'
INTO TABLE ojeadores
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Nombre, Apellido1, Apellido2, Apodo, Email, Telefono);

-- 7. JUGADORES
--    Columna CSV "Dorsal" → columna tabla "Dorsal_actual"
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/Jugadores.csv'
INTO TABLE jugadores
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Nombre, Apellido1, Apellido2, Apodo, Fecha_Nacimiento, Nacionalidad, Posicion_Principal, Posicion_Secundaria,
 Altura, Peso, Dorsal_actual, Club_Actual, Valor_Mercado, Agente, Foto_Perfil);
  
-- 8. TEMPORADA

LOAD DATA LOCAL INFILE '/vagrant/BD/datos/temporada.csv'
INTO TABLE temporada
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Nombre_Temporada);

-- 9. COMPETICION
--    Pais puede ser vacío (CL/EL) → convertir a NULL
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/competicion.csv'
INTO TABLE competicion
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Nombre, @pais, Tipo)
SET Pais = NULLIF(@pais, '');
  
-- 10. COMPETI_CLUBES
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/competi_clubes.csv'
INTO TABLE competi_clubes
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Club, ID_Competicion);
  
-- 11. TABLAS DE ENLACE: EMAIL
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/email_ojeador.csv'
INTO TABLE email_ojeador
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Email, ID_Ojeador);

LOAD DATA LOCAL INFILE '/vagrant/BD/datos/email_club.csv'
INTO TABLE email_club
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Email, ID_Club);

LOAD DATA LOCAL INFILE '/vagrant/BD/datos/email_agente.csv'
INTO TABLE email_agente
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Email, ID_Agente);
  
-- 12. TABLAS DE ENLACE: TELEFONO
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/telefono_ojeador.csv'
INTO TABLE telefono_ojeador
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Telefono, ID_Ojeador);

LOAD DATA LOCAL INFILE '/vagrant/BD/datos/telefono_club.csv'
INTO TABLE telefono_club
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Telefono, ID_Club);

LOAD DATA LOCAL INFILE '/vagrant/BD/datos/telefono_agente.csv'
INTO TABLE telefono_agente
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Telefono, ID_Agente);

-- 13. PARTIDOS_CUBIERTOS
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/partidos_cubiertos.csv'
INTO TABLE partidos_cubiertos
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Equipo_Local, Equipo_Visitante, Goles_Local, Goles_Visitante, Ganador, Fecha, Pais, Localidad);

-- 14. OJEADORES_PARTIDOS
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/ojeadores_partidos.csv'
INTO TABLE ojeadores_partidos
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Ojeador, ID_Partido_Cubierto);
  
-- 15. PARTIDOS_JUGADORES
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/partidos_jugadores.csv'
INTO TABLE partidos_jugadores
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Partido_Cubierto, ID_Jugador);
  
-- 16. CONTRATOS_REPRESENTACION
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/contratos_representacion.csv'
INTO TABLE contratos_representacion
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Jugador, Agente, Fecha_Inicio, Fecha_Fin, Porcentaje_Comision, Clausulas);
  
-- 17. CONTRATACIONES
--    Fecha_Rescision_Cancelacion vacía → NULL
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/contrataciones.csv'
INTO TABLE contrataciones
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Jugador, Club, Fecha_Inicio_Contrato, Fecha_Fin_Contrato, Sueldo, Porcentaje_Comision, Tipo_Contrato, Rol_Equipo,
 @fecha_rescision)
SET Fecha_Rescision_Cancelacion = NULLIF(@fecha_rescision, '');

-- 18. TRANSFERENCIAS
--    Comision_Agente vacía → NULL para que salte el trigger
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/transferencias.csv'
INTO TABLE transferencias
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Jugador, Club_Origen, Club_Destino, Fecha_Transferencia, Valor_Operacion, @comision, Agente)
SET Comision_Agente = NULLIF(@comision, '');
  
-- 19. TEMPORADA_JUGADOR
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/temporada_jugador.csv'
INTO TABLE temporada_jugador
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(ID_Jugador, ID_Temporada);
  
-- 20. ESTADISTICAS_JUGADOR
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/estadisticas_jugador.csv'
INTO TABLE estadisticas_jugador
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Jugador, Club, Temporada, Competicion, Partidos_jugados, Goles, Asistencias, Tarjetas_amarillas, Tarjetas_rojas);

-- 21. INFORMES_SCOUTING
  
LOAD DATA LOCAL INFILE '/vagrant/BD/datos/informes_scouting.csv'
INTO TABLE informes_scouting
CHARACTER SET utf8mb4
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(Jugador, Ojeador, Partido_Cubierto, Fecha_Informe, Valoraciones, Potencial, Recomendacion);

SET FOREIGN_KEY_CHECKS = 1;