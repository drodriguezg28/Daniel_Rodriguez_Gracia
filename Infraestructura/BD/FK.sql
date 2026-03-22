-- Informes_Scouting

ALTER TABLE informes_scouting
ADD CONSTRAINT jugadores_informes_socuting
FOREIGN KEY (Jugador)
REFERENCES jugadores(ID_Jugador);

ALTER TABLE informes_scouting
ADD CONSTRAINT ojeadores_informes_socuting
FOREIGN KEY (Ojeador)
REFERENCES ojeadores(ID_Ojeador);

ALTER TABLE informes_scouting
ADD CONSTRAINT partido_informes_socuting
FOREIGN KEY (Partido_Cubierto)
REFERENCES partidos_cubiertos(ID_Partido_Cubierto);

-- Ojeadores
/**
ALTER TABLE ojeadores
ADD CONSTRAINT email_ojeadores
FOREIGN KEY (Email)
REFERENCES email(ID_Email);

ALTER TABLE ojeadores
ADD CONSTRAINT telefono_ojeadores
FOREIGN KEY (Telefono)
REFERENCES telefono(ID_Telefono);
**/
-- Ojeadores_Partidos

ALTER TABLE ojeadores_partidos 
ADD CONSTRAINT ojeadores_ojeadores_partidos 
FOREIGN KEY (ID_Ojeador)
REFERENCES ojeadores(ID_Ojeador);

ALTER TABLE ojeadores_partidos
ADD CONSTRAINT partido_ojeadores_partidos 
FOREIGN KEY (ID_Partido_Cubierto)
REFERENCES partidos_cubiertos(ID_Partido_Cubierto);

-- partidos_cubiertos

ALTER TABLE partidos_cubiertos
ADD CONSTRAINT equipoL_partidos_cubiertos
FOREIGN KEY (Equipo_Local)
REFERENCES clubes(ID_Club);

ALTER TABLE partidos_cubiertos
ADD CONSTRAINT equipoV_partidos_cubiertos
FOREIGN KEY (Equipo_Visitante)
REFERENCES clubes(ID_Club);

ALTER TABLE partidos_cubiertos
ADD CONSTRAINT pais_partidos_cubiertos
FOREIGN KEY (Pais)
REFERENCES paises(ID_Pais);

-- partidos_jugadores

ALTER TABLE partidos_jugadores
ADD CONSTRAINT partido_partidos_jugadores
FOREIGN KEY (ID_Partido_Cubierto)
REFERENCES partidos_cubiertos(ID_Partido_Cubierto);

ALTER TABLE partidos_jugadores
ADD CONSTRAINT jugadores_partidos_jugadores
FOREIGN KEY (ID_Jugador)
REFERENCES jugadores(ID_Jugador);

-- Jugadores

ALTER TABLE jugadores
ADD CONSTRAINT nacionalidad_jugadores
FOREIGN KEY (Nacionalidad)
REFERENCES paises(ID_Pais);

ALTER TABLE jugadores
ADD CONSTRAINT club_jugadores
FOREIGN KEY (Club_Actual)
REFERENCES clubes(ID_Club);

ALTER TABLE jugadores
ADD CONSTRAINT agente_jugadores
FOREIGN KEY (Agente)
REFERENCES agentes(ID_Agente);

-- Contrataciones

ALTER TABLE contrataciones
ADD CONSTRAINT jugador_contrataciones
FOREIGN KEY (Jugador)
REFERENCES jugadores(ID_Jugador);

ALTER TABLE contrataciones
ADD CONSTRAINT club_contrataciones
FOREIGN KEY (Club)
REFERENCES clubes(ID_Club);

-- Transferencias

ALTER TABLE transferencias
ADD CONSTRAINT jugador_transferencias
FOREIGN KEY (Jugador)
REFERENCES jugadores(ID_Jugador);

ALTER TABLE transferencias
ADD CONSTRAINT club_Origen_transferencias
FOREIGN KEY (Club_Origen)
REFERENCES clubes(ID_Club);

ALTER TABLE transferencias
ADD CONSTRAINT club_Destino_transferencias
FOREIGN KEY (Club_Destino)
REFERENCES clubes(ID_Club);

ALTER TABLE transferencias
ADD CONSTRAINT agente_transferencias
FOREIGN KEY (Agente)
REFERENCES agentes(ID_Agente);

-- Contratos_Representacion

ALTER TABLE contratos_representacion
ADD CONSTRAINT jugador_contratos_representacion
FOREIGN KEY (Jugador)
REFERENCES jugadores(ID_Jugador);

ALTER TABLE contratos_representacion
ADD CONSTRAINT agente_contratos_representacion
FOREIGN KEY (Agente)
REFERENCES agentes(ID_Agente);

-- Agentes

ALTER TABLE agentes
ADD CONSTRAINT nacionalidad_agentes
FOREIGN KEY (Nacionalidad)
REFERENCES paises(ID_Pais);

-- Competi_Clubes

ALTER TABLE competi_clubes
ADD CONSTRAINT club_competi_clubes
FOREIGN KEY (ID_Club)
REFERENCES clubes(ID_Club);

ALTER TABLE competi_clubes
ADD CONSTRAINT competicion_competi_clubes
FOREIGN KEY (ID_Competicion)
REFERENCES competicion(ID_Competicion);

-- Competicion

ALTER TABLE competicion
ADD CONSTRAINT pais_competicion
FOREIGN KEY (Pais)
REFERENCES paises(ID_Pais);

-- Estadisticas_Jugador

ALTER TABLE estadisticas_jugador
ADD CONSTRAINT jugador_estadisticas_jugador
FOREIGN KEY (Jugador)
REFERENCES jugadores(ID_Jugador);

ALTER TABLE estadisticas_jugador
ADD CONSTRAINT club_estadisticas_jugador
FOREIGN KEY (Club)
REFERENCES clubes(ID_Club);

ALTER TABLE estadisticas_jugador
ADD CONSTRAINT temporada_estadisticas_jugador
FOREIGN KEY (Temporada)
REFERENCES temporada(ID_Temporada);

ALTER TABLE estadisticas_jugador
ADD CONSTRAINT competicion_estadisticas_jugador
FOREIGN KEY (Competicion)
REFERENCES competicion(ID_Competicion);

-- Temporada_Jugador

ALTER TABLE temporada_jugador
ADD CONSTRAINT jugador_temporada_jugador
FOREIGN KEY (ID_Jugador)
REFERENCES jugadores(ID_Jugador);

ALTER TABLE temporada_jugador
ADD CONSTRAINT temporada_temporada_jugador
FOREIGN KEY (ID_Temporada)
REFERENCES temporada(ID_Temporada);

-- Email_ojeador

ALTER TABLE email_ojeador
ADD CONSTRAINT email_email_ojeador
FOREIGN KEY (ID_Email)
REFERENCES email(ID_Email);

ALTER TABLE email_ojeador
ADD CONSTRAINT ojeador_email_ojeador
FOREIGN KEY (ID_Ojeador)
REFERENCES ojeadores(ID_Ojeador);

-- Email_club

ALTER TABLE email_club
ADD CONSTRAINT email_email_club
FOREIGN KEY (ID_Email)
REFERENCES email(ID_Email);

ALTER TABLE email_club
ADD CONSTRAINT club_email_club
FOREIGN KEY (ID_Club)
REFERENCES clubes(ID_Club);

-- Email_agente

ALTER TABLE email_agente
ADD CONSTRAINT email_email_agente
FOREIGN KEY (ID_Email)
REFERENCES email(ID_Email);

ALTER TABLE email_agente
ADD CONSTRAINT agente_email_agente
FOREIGN KEY (ID_Agente)
REFERENCES agentes(ID_Agente);

-- Telefono_ojeador

ALTER TABLE telefono_ojeador
ADD CONSTRAINT telefono_telefono_ojeador
FOREIGN KEY (ID_Telefono)
REFERENCES telefono(ID_Telefono);

ALTER TABLE telefono_ojeador
ADD CONSTRAINT ojeador_telefono_ojeador
FOREIGN KEY (ID_Ojeador)
REFERENCES ojeadores(ID_Ojeador);

-- Telefono_club

ALTER TABLE telefono_club
ADD CONSTRAINT telefono_telefono_club
FOREIGN KEY (ID_Telefono)
REFERENCES telefono(ID_Telefono);

ALTER TABLE telefono_club
ADD CONSTRAINT club_telefono_club
FOREIGN KEY (ID_Club)
REFERENCES clubes(ID_Club);

-- Telefono_agente

ALTER TABLE telefono_agente
ADD CONSTRAINT telefono_Telefono_agente
FOREIGN KEY (ID_Telefono)
REFERENCES telefono(ID_Telefono);

ALTER TABLE telefono_agente
ADD CONSTRAINT agente_Telefono_agente
FOREIGN KEY (ID_Agente)
REFERENCES agentes(ID_Agente);