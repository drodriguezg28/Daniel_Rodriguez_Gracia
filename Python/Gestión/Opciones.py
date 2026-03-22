import MIMODULO as MIMODULO, csv

#########################################################################
#########################################################################
dirusuarios = "c:/archivospy/proyecto/usuarios.csv"                  ####
dirjugadores = "c:/archivospy/proyecto/jugadores.csv"                ####
diragentes = "c:/archivospy/proyecto/agentes.csv"                    ####
dirojeadores = "c:/archivospy/proyecto/ojeadores.csv"                ####
dirasignaciones = "c:/archivospy/proyecto/asignaciones.csv"          ####
dirpartidos = "c:/archivospy/proyecto/partidos.csv"                  ####
# dirinformes = "c:/archivospy/proyecto/informes.csv"                ####
usuarios = MIMODULO.cargar_csv(dirusuarios)                          ####
jugadores = MIMODULO.cargar_csv(dirjugadores)                        ####
agentes = MIMODULO.cargar_csv(diragentes)                            ####
ojeadores = MIMODULO.cargar_csv(dirojeadores)                        ####
asignaciones = MIMODULO.cargar_csv(dirasignaciones)                  ####
partidos = MIMODULO.cargar_csv(dirpartidos)                          ####
# informes = MIMODULO.cargar_csv(dirinformes)                        ####
#########################################################################
#########################################################################

###################
# RECARGAR LISTAS #
###################

def recargar_todas_listas():
    global usuarios, ojeadores, agentes, jugadores, asignaciones
    
    usuarios = MIMODULO.cargar_csv(dirusuarios)
    ojeadores = MIMODULO.cargar_csv(dirojeadores)
    agentes = MIMODULO.cargar_csv(diragentes)
    jugadores = MIMODULO.cargar_csv(dirjugadores)
    asignaciones = MIMODULO.cargar_csv(dirasignaciones)

###################
# VER PERSONA #####
###################


def ver_agente(agente):
    print(f"\n Nombre: {agente['nombre']}  Pais: {agente['pais']}")   

def ver_ojeador(ojeador):
    print(f"\n {ojeador['nombre']} (Zona: {ojeador['zona']})")

def ver_jugador(jugador):
    print(f"\n      Nombre: {jugador['nombre']} Edad: {jugador['edad']} Posición: {jugador['posicion']}")   

def ver_jugador_jugador(jugador):
    print(f"\nNombre: \033[1m{jugador['nombre']}\033[0m \nEdad: \033[1m{jugador['edad']} años\033[0m \nPosición: \033[1m{jugador['posicion']}\033[0m \n")

###################
# BUSCAR PERSONA ##
###################

def buscar_jugador(fila_usuario):

    # Buscar asignación del jugador
    asignacion_jugador = None
    for a in asignaciones:
        if str(a.get('jugadorid', '')) == str(fila_usuario['id']):  # ← usa jugador['id']
            asignacion_jugador = a
            break

    if not asignacion_jugador:
        print("   -> No tiene agente ni ojeador asignados.")
        return
    
    # BUSQUEDA AGENTE
    agente = None
    agente_id = asignacion_jugador.get('agenteid')
    if agente_id not in (None, '', ' '):
        for ag in agentes:
            if str(ag['id']).strip() == str(agente_id).strip():
                agente = ag
                break

    # BUSQUEDA OJEADOR 
    ojeador = None
    ojeador_id = asignacion_jugador.get('ojeadorid')
    if ojeador_id not in (None, '', ' '):
        for oj in ojeadores:
            if str(oj['id']).strip() == str(ojeador_id).strip():
                ojeador = oj
                break

    # MOSTRAR

    if agente:
        print(f"\n           Agente asignado: {agente['nombre']}")
    else:
        print("\n           No tiene agente asignado.")

    if ojeador:
        print(f"\n           Ojeador asignado: {ojeador['nombre']}\n")
    else:
        print("\n           No tiene ojeador asignado.\n")



def buscar_agente(agente_actual):
    
    jugadores_asignados = []
    
    for asignacion in asignaciones:
        id_en_asignacion = str(asignacion.get('agenteid', '')).strip()
        id_del_agente = str(agente_actual['id']).strip()
        
        if id_en_asignacion == id_del_agente:
            jugadores_asignados.append(asignacion['jugadorid'])
    
    if not jugadores_asignados:
        print("\n -> No tiene jugadores asignados.")
        return

    for jugador_id in jugadores_asignados:
        jugador_encontrado = None
        
        for j in jugadores:
            if str(j['id']).strip() == str(jugador_id).strip():
                jugador_encontrado = j
                break
        
        if jugador_encontrado:
            ver_jugador(jugador_encontrado)




def buscar_ojeador(ojeador_actual):
    jugadores_asignados = []
    
    for asignacion in asignaciones:
        
        id_asignacion = str(asignacion.get('ojeadorid', '')).strip()
        id_ojeador = str(ojeador_actual['id']).strip()
        
        if id_asignacion == id_ojeador:
            jugadores_asignados.append(asignacion['jugadorid'])
    
    # Informar resultados
    if not jugadores_asignados:
        print("\n -> No tiene jugadores asignados.")
        return

    for jugador_id in jugadores_asignados:
        jugador_encontrado = None
        
        for j in jugadores:
            if str(j['id']).strip() == str(jugador_id).strip():
                jugador_encontrado = j
                break
        
        if jugador_encontrado:
            ver_jugador(jugador_encontrado)



###################
# AÑADIR PERSONA ##
###################

def añadir_persona():
    id = MIMODULO.nuevo_id(usuarios) # SACAR ID QUE SE LE ASIGNARÁ AL NUEVO USUARIO
    nombre = input("Introduce el nombre del nuevo jugador: ")
    usuario = input("Introduce el usuario del nuevo jugador: ")
    while usuario in [u['usuario'] for u in usuarios]: # COMPROBAR QUE NO EXISTE ESE USUARIO
        print("Error: Este usuario ya está registrado.")
        usuario = input("Introduce un nombre de usuario diferente: ")
    contraseña = input("Introduce la contraseña del nuevo integrante: ")
    return id, nombre, usuario, contraseña






###################
# MODIFICAR DATO ##
###################

def buscar_nombre_usuario(donde):
    tipo =""
    nom = ""
    print("1. Buscar por nombre")
    print("2. Buscar por usuario")
    seleccion = input("¿Que tipo de busqueda te gustaría realizar? ")
    while seleccion not in ["1", "2"]:
        print(f"Error: {seleccion} no es un departamento válido.")
        print("¿De quien quieres modificar un dato?")
        print("1. Buscar por nombre")
        print("2. Buscar por usuario")
        seleccion = input("¿Que tipo de busqueda te gustaría realizar? ")
    
    match int(seleccion):
        case 1:
            nombre = input("¿Que Nombre quieres buscar?: ")
            tipo = "nombre"
            while nombre not in [u['nombre'] for u in donde]: # COMPROBAR QUE EXISTE ESE NOMBRE
                print("Error: Este nombre no está registrado.")
                nombre = input("Introduce un nombre diferente: ")
                nom = nombre
            return nombre, tipo, nom
        case 2:
            usuario = input("¿Que Usuario quieres buscar?: ")
            tipo = "usuario"
            while usuario not in [u['usuario'] for u in donde]: # COMPROBAR QUE EXISTE ESE USUARIO
                print("Error: Este usuario no está registrado.")
                usuario = input("Introduce un nombre de usuario diferente: ")

            for usu in usuarios:
                if str(usu['usuario']).lower() == str(usuario).lower():
                    nom = usu['nombre']
                    break

            return usuario, tipo, nom
            

def tiene_valor_asignado(lista_datos, id_buscar, columna_id, columna_revisar):
    """
    Busca una fila por su ID y comprueba si otra columna tiene datos.
    
    Args:
        lista_datos: La lista donde buscar (ej: asignaciones).
        id_buscar: El ID de la fila que queremos mirar (ej: 4).
        columna_id: El nombre de la columna ID (ej: 'jugadorid').
        columna_revisar: La columna que queremos ver si está llena (ej: 'ojeadorid').
        
    Returns:
        True si TIENE algo escrito.
        False si está vacía o no existe la fila.
    """
    id_buscar = str(id_buscar).strip()
    
    for fila in lista_datos:
        # 1. Encontramos la fila correcta (ej: la del jugador 4)
        if str(fila.get(columna_id, '')) == id_buscar:
            
            # 2. Miramos si la columna objetivo tiene algo
            valor = str(fila.get(columna_revisar, '')).strip()
            
            # Si el valor no está vacío y no es 'None', devuelve True
            if valor and valor.lower() != 'none' or valor and valor.lower() != "":
                return True
            else:
                return False
                
    return False



def modificar_asignacion(sitio, dircsv, campoelegir,iddondecambio, nuevo_id, tipo_campo):
    """
    Modifica una asignación en el CSV
    
    Args:
        sitio: lista de diccionarios con las asignaciones
        dircsv: ruta del archivo CSV
        iddondecambio: ID del jugador cuya asignación se va a modificar
        nuevo_id: nuevo ID a asignar (ojeador o agente)
        tipo_campo: 'ojeadorid' o 'agenteid'
    """

    # Buscar y modificar
    for fila in sitio:
        if str(fila[campoelegir]).strip() == str(iddondecambio).strip():
            fila[tipo_campo] = str(nuevo_id)
    
    with open(dircsv, 'w', newline='', encoding='utf-8') as archivo:
        campos = list(sitio[0].keys())
        escritor = csv.DictWriter(archivo, fieldnames=campos)
        escritor.writeheader()
        escritor.writerows(sitio)
        
    recargar_todas_listas()


def crear_asignacion(asignaciones, dirasignaciones, idjugador, idojeador=None, idagente=None):
    """
    Crea una nueva asignación en el CSV
    
    Args:
        asignaciones: lista de diccionarios con las asignaciones
        dirasignaciones: ruta del archivo CSV
        idjugador: ID del jugador
        idojeador: ID del ojeador (opcional)
        idagente: ID del agente (opcional)
    """
    # Calcular el nuevo ID
    nuevo_id = MIMODULO.nuevo_id(asignaciones)
    
    # Crear la nueva asignación
    nueva_asignacion = {
        'id': str(nuevo_id),
        'jugadorid': str(idjugador),
        'ojeadorid': str(idojeador) if idojeador else '',
        'agenteid': str(idagente) if idagente else ''
    }
    
    # Agregar a la lista
    asignaciones.append(nueva_asignacion)
    
    # Guardar los cambios
    with open(dirasignaciones, 'w', newline='') as archivo:
        campos = ['id', 'jugadorid', 'ojeadorid', 'agenteid']
        escritor = csv.DictWriter(archivo, fieldnames=campos)
        escritor.writeheader()
        escritor.writerows(asignaciones)

    recargar_todas_listas()