CREATE TABLE paises (
    ID_Pais    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Pais       VARCHAR(30),
    Continente VARCHAR(30)
);

CREATE TABLE email (
    ID_Email INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Email    VARCHAR(50) CHECK (Email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$')
);

CREATE TABLE telefono (
    ID_Telefono INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Telefono    VARCHAR(50) CHECK (Telefono REGEXP '^\\+[1-9][0-9]{7,14}$')
);

CREATE TABLE temporada (
    ID_Temporada     INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre_Temporada VARCHAR(7) CHECK (
        LENGTH(Nombre_Temporada) = 7
        AND Nombre_Temporada REGEXP '^[0-9]{4}/[0-9]{2}$'
    )
);

CREATE TABLE agentes (
    ID_Agente    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre       VARCHAR(30),
    Apellido1    VARCHAR(30),
    Apellido2    VARCHAR(30),
    Email        INT,
    Telefono     INT,
    Nacionalidad INT
);

CREATE TABLE clubes (
    ID_Club  INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre   VARCHAR(30),
    Telefono INT,
    Email    INT,
    url_logo VARCHAR(255)
);

CREATE TABLE ojeadores (
    ID_Ojeador INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre     VARCHAR(30),
    Apellido1  VARCHAR(30),
    Apellido2  VARCHAR(30),
    Apodo      VARCHAR(50),
    Email      INT,
    Telefono   INT
);

CREATE TABLE competicion (
    ID_Competicion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre         VARCHAR(50),
    Pais           INT,
    Tipo           VARCHAR(50) CHECK (Tipo IN (
        'Liga','Copa Nacional','Copa de la Liga','Supercopa',
        'Copa Continental','Copa Intercontinental','Torneo Amistoso'
    ))
);

CREATE TABLE jugadores (
    ID_Jugador          INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre              VARCHAR(30),
    Apellido1           VARCHAR(30),
    Apellido2           VARCHAR(30),
    Apodo               VARCHAR(30),
    Fecha_Nacimiento    DATE,
    Nacionalidad        INT,
    Altura              DECIMAL(3,2),
    Peso                DECIMAL(5,2),
    Posicion_Principal  ENUM(
        'Portero','Defensa Central','Lateral Derecho','Lateral Izquierdo',
        'Carrilero','Pivote','Mediocentro','Mediapunta',
        'Interior Derecho','Interior Izquierdo','Extremo Derecho','Extremo Izquierdo',
        'Segundo Delantero','Delantero Centro'
    ),
    Posicion_Secundaria ENUM(
        'Portero','Defensa Central','Lateral Derecho','Lateral Izquierdo',
        'Carrilero','Pivote','Mediocentro','Mediapunta',
        'Interior Derecho','Interior Izquierdo','Extremo Derecho','Extremo Izquierdo',
        'Segundo Delantero','Delantero Centro'
    ),
    Dorsal_actual INT,
    Club_Actual   INT,
    Valor_Mercado DECIMAL(12,2),
    Agente        INT,
    Foto_Perfil   VARCHAR(255)
);

CREATE TABLE competi_clubes (
    ID_Club        INT NOT NULL,
    ID_Competicion INT NOT NULL,
    PRIMARY KEY (ID_Club, ID_Competicion)
);

CREATE TABLE partidos_cubiertos (
    ID_Partido_Cubierto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Equipo_Local        INT,
    Equipo_Visitante    INT,
    Goles_Local         INT,
    Goles_Visitante     INT,
    Ganador             VARCHAR(9) CHECK (Ganador IN ('Local','Empate','Visitante')),
    Fecha               DATE DEFAULT (CURRENT_DATE),
    Pais                INT,
    Localidad           VARCHAR(30)
);

CREATE TABLE contrataciones (
    ID_Contratacion             INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Jugador                     INT,
    Club                        INT,
    Fecha_Inicio_Contrato       DATE,
    Fecha_Fin_Contrato          DATE,
    Sueldo                      DECIMAL(10,2),
    Porcentaje_Comision         DECIMAL(5,2) DEFAULT 0 CHECK (Porcentaje_Comision <= 10.00),
    Duracion_restante           INT AS (DATEDIFF(Fecha_Fin_Contrato, Fecha_Inicio_Contrato)) VIRTUAL,
    Tipo_Contrato               VARCHAR(10) CHECK (Tipo_Contrato IN ('Cesion','Renovacion','Compra','Libre')),
    Rol_Equipo                  VARCHAR(12) CHECK (Rol_Equipo IN ('Titular','Suplente','Cantera')),
    Fecha_Rescision_Cancelacion DATE
);

CREATE TABLE transferencias (
    ID_Transferencia    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Jugador             INT,
    Club_Origen         INT,
    Club_Destino        INT,
    Fecha_Transferencia DATE,
    Valor_Operacion     DECIMAL(12,2),
    Comision_Agente     DECIMAL(10,2),
    Agente              INT
);

CREATE OR REPLACE TRIGGER calcular_comision
BEFORE INSERT ON transferencias
FOR EACH ROW
SET NEW.Comision_Agente = IF(NEW.Comision_Agente IS NULL, NEW.Valor_Operacion * 0.10, NEW.Comision_Agente);

CREATE TABLE contratos_representacion (
    ID_Contrato         INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Jugador             INT,
    Agente              INT,
    Fecha_Inicio        DATE NOT NULL,
    Fecha_Fin           DATE,
    Tiempo_Restante     INT GENERATED ALWAYS AS (DATEDIFF(Fecha_Fin, Fecha_Inicio)) VIRTUAL,
    Porcentaje_Comision DECIMAL(5,2) DEFAULT 0 CHECK (Porcentaje_Comision <= 10.00),
    Clausulas           VARCHAR(2000)
);

CREATE TABLE estadisticas_jugador (
    ID_Estadisticas    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Jugador            INT,
    Club               INT,
    Temporada          INT,
    Competicion        INT,
    Partidos_jugados   INT,
    Goles              INT,
    Asistencias        INT,
    Tarjetas_amarillas INT,
    Tarjetas_rojas     INT
);

CREATE TABLE temporada_jugador (
    ID_Jugador   INT NOT NULL,
    ID_Temporada INT NOT NULL,
    PRIMARY KEY (ID_Jugador, ID_Temporada)
);

CREATE TABLE partidos_jugadores (
    ID_Partido_Cubierto INT NOT NULL,
    ID_Jugador          INT NOT NULL,
    PRIMARY KEY (ID_Jugador, ID_Partido_Cubierto)
);

CREATE TABLE ojeadores_partidos (
    ID_Ojeador          INT NOT NULL,
    ID_Partido_Cubierto INT NOT NULL,
    PRIMARY KEY (ID_Ojeador, ID_Partido_Cubierto)
);

CREATE TABLE informes_scouting (
    ID_Informe       INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Jugador          INT,
    Ojeador          INT,
    Partido_Cubierto INT,
    Fecha_Informe    DATE,
    Valoraciones     VARCHAR(2000),
    Potencial        VARCHAR(20) CHECK (Potencial IN (
        'Bajo','Medio','Alto','Elite','Generacional',
        'Estable','En Declive','Ultimos Anos'
    )),
    Recomendacion    VARCHAR(20) CHECK (Recomendacion IN (
        'Demasiado Pronto','Nada Recomendable','Recomendable','Muy Recomendable'
    ))
);

CREATE TABLE email_ojeador (
    ID_Email   INT NOT NULL,
    ID_Ojeador INT NOT NULL,
    PRIMARY KEY (ID_Email, ID_Ojeador)
);

CREATE TABLE email_club (
    ID_Email INT NOT NULL,
    ID_Club  INT NOT NULL,
    PRIMARY KEY (ID_Email, ID_Club)
);

CREATE TABLE email_agente (
    ID_Email  INT NOT NULL,
    ID_Agente INT NOT NULL,
    PRIMARY KEY (ID_Email, ID_Agente)
);

CREATE TABLE telefono_ojeador (
    ID_Telefono INT NOT NULL,
    ID_Ojeador  INT NOT NULL,
    PRIMARY KEY (ID_Telefono, ID_Ojeador)
);

CREATE TABLE telefono_club (
    ID_Telefono INT NOT NULL,
    ID_Club     INT NOT NULL,
    PRIMARY KEY (ID_Telefono, ID_Club)
);

CREATE TABLE telefono_agente (
    ID_Telefono INT NOT NULL,
    ID_Agente   INT NOT NULL,
    PRIMARY KEY (ID_Telefono, ID_Agente)
);