create database if not exists elitescouting;
use elitescouting;


create table informes_scouting (
	ID_Informe int not null auto_increment primary key,
    Jugador int, -- FK
    Ojeador int, -- FK
    Partido_Cubierto int, -- FK
    Fecha_Informe date,
    Valoraciones Varchar(2000),
    Potencial VARCHAR(20) CHECK(Potencial IN ('Bajo','Medio','Alto','Élite','Generacional','Estable','En Declive','Últimos Años')),
	Recomendacion VARCHAR(20) CHECK(Recomendacion IN ('Demasiado Pronto','Nada Recomendable','Recomendable','Muy Recomendable'))
);

create table ojeadores (
ID_Ojeador int not null auto_increment primary key,
Nombre varchar(30),
Apellido1 varchar(30),
Apellido2 varchar(30),
Apodo varchar(50),
Email int, -- FK
Telefono int, -- FK
Nacionalidad int, -- FK
Usuario bigint -- FK
);



create table ojeadores_partidos (
ID_Ojeador int not null, -- FK
ID_Partido_Cubierto int not null, -- FK
PRIMARY KEY (ID_Ojeador, ID_Partido_Cubierto)
);


create table partidos_cubiertos (
ID_Partido_Cubierto int not null auto_increment primary key,
Equipo_Local int, -- FK
Equipo_Visitante int, -- FK
Goles_Local int,
Goles_Visitante int,
Ganador varchar(9) check (Ganador IN ("Local","Empate" , "Visitante")),
Fecha DATE DEFAULT (CURRENT_DATE),
Pais int, -- FK
Localidad varchar(30)
);


create table partidos_jugadores(
ID_Partido_Cubierto int not null, -- FK
ID_Jugador int not null, -- FK
PRIMARY KEY (ID_Jugador, ID_Partido_Cubierto)
);


create table paises (
ID_Pais int not null auto_increment primary key,
Pais varchar(40), -- poner 40
Continente varchar(30),
Bandera varchar(255)
);


create table jugadores (
ID_Jugador int not null auto_increment primary key,
Nombre varchar(30),
Apellido1 varchar(30),
Apellido2 varchar(30),
Apodo varchar(30),
Fecha_Nacimiento date,
Nacionalidad int, -- FK
Altura decimal(3,2),
Peso decimal(5,2),
Posicion_Principal ENUM (
        'Portero', 'Defensa Central', 'Lateral Derecho', 'Lateral Izquierdo', 'Carrilero', 'Pivote', 'Mediocentro', 'Mediapunta', 
        'Interior Derecho', 'Interior Izquierdo', 'Extremo Derecho', 'Extremo Izquierdo', 'Segundo Delantero', 'Delantero Centro'),
Posicion_Secundaria ENUM(
        'Ninguna', 'Portero', 'Defensa Central', 'Lateral Derecho', 'Lateral Izquierdo', 'Carrilero', 'Pivote', 'Mediocentro', 'Mediapunta', 
        'Interior Derecho', 'Interior Izquierdo', 'Extremo Derecho', 'Extremo Izquierdo', 'Segundo Delantero', 'Delantero Centro'),
Dorsal_actual int,
Club_Actual int, -- FK
Valor_Mercado decimal(12,2), -- FORMAT(Valor_Mercado, 'N2', 'es-ES')
Agente int, -- FK,
Usuario bigint, -- FK
Foto_Perfil varchar(255)
);


create table contrataciones(
ID_Contratacion int not null auto_increment primary key,
Jugador int, -- FK
Club int, -- FK
Fecha_Inicio_Contrato date,
Fecha_Fin_Contrato date,
Sueldo decimal(10,2), -- FORMAT(Valor_Mercado, 'N2', 'es-ES')
Porcentaje_Comision DECIMAL(5,2) CHECK (Porcentaje_Comision <= 10.00), -- Crear Trigger para calcular comision sobre el coste/Sueldo  -- FORMAT(Valor_Mercado, 'N2', 'es-ES')
Duracion_restante INT AS (DATEDIFF(Fecha_Fin_Contrato, Fecha_Inicio_Contrato)) VIRTUAL, -- (fecha fin - fecha inicio) -- se puede hacer con trigger
Tipo_Contrato VARCHAR(10) check (Tipo_Contrato IN ("Cesión","Renovación","Compra", "Libre")),
Rol_Equipo VARCHAR(12) check(Rol_Equipo IN ("Titular","Suplente","Cantera")),
Fecha_Rescision_Cancelacion date
);


create table transferencias(
ID_Transferencia int not null auto_increment primary key,
Jugador int, -- FK
Club_Origen int, -- FK
Club_Destino int, -- FK
Fecha_Transferencia date,
Valor_Operacion decimal(12,2), -- FORMAT(Valor_Mercado, 'N2', 'es-ES')
Comision_Agente decimal (10,2), -- Crear Trigger para calcular comision sobre el coste/Sueldo  -- FORMAT(Valor_Mercado, 'N2', 'es-ES') -- FK
Agente int -- FK
);


-- Trigger
DELIMITER //

CREATE TRIGGER calcular_comision
BEFORE INSERT ON transferencias
FOR EACH ROW
BEGIN
    IF NEW.Comision_Agente IS NULL THEN
        SET NEW.Comision_Agente = NEW.Valor_Operacion * 0.10;
    END IF;
END //

DELIMITER ;


create table contratos_representacion (
ID_Contrato int not null auto_increment primary key,
Jugador int, -- FK
Agente int, -- FK
Fecha_Inicio date not null,
Fecha_Fin date,
Tiempo_Restante int GENERATED ALWAYS AS (DATEDIFF(Fecha_Fin, Fecha_Inicio)) VIRTUAL, -- (fecha fin - fecha inicio)
Porcentaje_Comision DECIMAL(5,2) DEFAULT 0 CHECK (Porcentaje_Comision <= 10.00),
Clausulas varchar(2000)
);

create table agentes(
ID_Agente int not null auto_increment primary key,
Nombre varchar(30),
Apellido1 varchar(30),
Apellido2 varchar(30),
Email int, -- FK
Telefono int, -- FK
Nacionalidad int, -- FK
Usuario bigint -- FK
);


create table clubes(
ID_club int not null auto_increment primary key,
Nombre varchar(30),
Pais int,
Telefono int, -- FK
Email int, -- FK
Usuario bigint, -- FK
url_logo varchar(255)
);




create table competi_clubes(
ID_Club int not null, -- FK
ID_Competicion int not null, -- FK
PRIMARY KEY (ID_Club, ID_Competicion)
);


create table competicion(
ID_Competicion int not null auto_increment primary key,
Nombre varchar(50),
Pais int, -- FK
Tipo varchar(50) check (Tipo IN ("Liga","Copa Nacional","Copa de la Liga","Supercopa","Copa Continental","Copa Intercontinental","Torneo Amistoso")) -- (liga, copa, torneos continentales…)
);


create table estadisticas_jugador(
ID_Estadisticas int not null auto_increment primary key,
Jugador int, -- FK
Club int, -- FK
Temporada int, -- FK
Competicion int, -- FK
Partidos_jugados int,
Goles int, 
Asistencias int,
Tarjetas_amarillas int,
Tarjetas_rojas int
);


create table temporada_jugador(
ID_Jugador int not null, -- FK
ID_Temporada int not null, -- FK
PRIMARY KEY (ID_Jugador, ID_Temporada)
);


create table temporada(
ID_Temporada  int not null auto_increment primary key,
Nombre_Temporada varchar (7) check (length(Nombre_Temporada) = 7 and Nombre_Temporada REGEXP '^[0-9]{4}/[0-9]{2}$') -- Formato 2025/26
);


create table email(
ID_Email  int not null auto_increment primary key,
Email varchar(50) check (Email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$')
);


create table email_ojeador(
ID_Email int not null, -- FK
ID_Ojeador int not null, -- FK
PRIMARY KEY (ID_Email, ID_Ojeador)
);


create table email_club(
ID_Email int not null, -- FK
ID_Club int not null, -- FK
PRIMARY KEY (ID_Email, ID_Club)
);


create table email_agente(
ID_Email int not null, -- FK
ID_Agente int not null, -- FK
PRIMARY KEY (ID_Email, ID_Agente)
);


create table telefono(
ID_Telefono  int not null auto_increment primary key,
Telefono varchar(50) check (Telefono REGEXP '^\\+[1-9][0-9]{7,14}$')
);


create table telefono_ojeador(
ID_Telefono int not null, -- FK
ID_Ojeador int not null, -- FK
PRIMARY KEY (ID_Telefono, ID_Ojeador)
);


create table telefono_club(
ID_Telefono int not null, -- FK
ID_Club int not null, -- FK
PRIMARY KEY (ID_Telefono, ID_Club)
);


create table telefono_agente(
ID_Telefono int not null, -- FK
ID_Agente int not null, -- FK
PRIMARY KEY (ID_Telefono, ID_Agente)
);
