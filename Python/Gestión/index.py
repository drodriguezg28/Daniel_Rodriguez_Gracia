import MIMODULO as MIMODULO, csv, time, Opciones

salir = False
opcion = 0

# ============================================
# CARGA DE TODOS LOS ARCHIVOS CSV
# ============================================

dirusuarios = "c:/archivospy/proyecto/usuarios.csv"
dirjugadores = "c:/archivospy/proyecto/jugadores.csv"
diragentes = "c:/archivospy/proyecto/agentes.csv"
dirojeadores = "c:/archivospy/proyecto/ojeadores.csv"
dirasignaciones = "c:/archivospy/proyecto/asignaciones.csv"
dirpartidos = "c:/archivospy/proyecto/partidos.csv"
# dirinformes = "c:/archivospy/proyecto/informes.csv"
usuarios = MIMODULO.cargar_csv(dirusuarios)
jugadores = MIMODULO.cargar_csv(dirjugadores)
agentes = MIMODULO.cargar_csv(diragentes)
ojeadores = MIMODULO.cargar_csv(dirojeadores)
asignaciones = MIMODULO.cargar_csv(dirasignaciones)
partidos = MIMODULO.cargar_csv(dirpartidos)
# informes = MIMODULO.cargar_csv(dirinformes)

print("Datos cargados correctamente.\n")

# ============================================
# VERIFICAR USUARIO Y CONTRASEÑA
# ============================================
usu = input("Introduce tu nombre de Usuario: ")
contra = input("Introduce tu Contraseña: ")

# Buscar si el usuario existe y la contraseña es correcta
fila_usuario = MIMODULO.verificar_login(usu, contra, usuarios)

# Si el usuario no tiene rol, salir del programa
if fila_usuario is None:
    print("Usuario no encontrado")
    exit()
elif fila_usuario.get('rol') is None:
    print("El usuario no tiene un rol asignado.")
    exit()
else:
    print(f"\nBienvenido {fila_usuario['nombre']} ({fila_usuario['rol']})\n")

# ============================================
# MOSTRAR INFORMACIÓN SEGÚN EL ROL
# ============================================

# ROL: DIRECTOR
if fila_usuario['rol'] == 'director':
    while salir == False:
        print("1. Ver Ojeadores y sus Jugadores Asignados")
        print("2. Ver Agentes y sus Jugadores Asignados")
        print("3. Ver Jugadores")
        print("4. Añadir Nuevo Miembro")
        print("5. Añadir o Modificar Datos a una Persona")
        print("6. Salir")
        inpopcion = int(input("Que opción te gustaría utilizar? "))
        opcion = int(inpopcion)
        

        
        if opcion == 1: # OJEADORES
            print("OJEADORES Y SUS JUGADORES ASIGNADOS")
            
            # Recorrer todos los ojeadores
            for ojeador in ojeadores:
                Opciones.ver_ojeador(ojeador)
                Opciones.buscar_ojeador(ojeador)
        if opcion == 2: # AGENTES

            print("AGENTES Y SUS JUGADORES ASIGNADOS")
            
            for agente in agentes:
                Opciones.ver_agente(agente)
                Opciones.buscar_agente(agente)
                

        if opcion == 3: # JUGADORES

            print("JUGADORES EN LA AGENCIA")

            for jugador in jugadores:
                Opciones.ver_jugador(jugador)
                Opciones.buscar_jugador(jugador)

        if opcion == 4: #AÑADIR OTRA PERSONA
            print("AÑADIR UNA NUEVA PERSONA")
            print("DEPARTAMENTOS:")
            print("director")
            print("ojeador")
            print("agente")
            print("jugador")

            elegir = input("¿A que departamento lo quieres agregar?: ").lower()

            while elegir not in ["director","ojeador","agente","jugador"]: # COMPROBAR QUE ESTÁ DENTRO DE ESOS NOMBRES
                print(f"Error: {elegir} no es un departamento válido.")
                elegir = input("¿A que departamento lo quieres agregar?: ")
            
            id, nombre, usuario, contraseña = Opciones.añadir_persona()


            añadir = (id,nombre,usuario,contraseña,elegir)
            MIMODULO.añadir_al_csv(dirusuarios, añadir)

            match elegir:
                case "director":

                    print("Director añadido con éxito.\n")
                
                case "ojeador":

                    zona =  input("Introduce la zona del nuevo ojeador: ")
                    id2 = MIMODULO.nuevo_id(dirojeadores)
                    añadir = [id2,nombre,zona]
                    MIMODULO.añadir_al_csv(dirojeadores,añadir)
                    print("Ojeador añadido con éxito.\n")

                    usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV
                    ojeadores = MIMODULO.cargar_csv(dirojeadores)  # Recarga desde CSV

                case "agente":

                    pais =  input("Introduce el pais del nuevo agente: ")
                    id2 = MIMODULO.nuevo_id(diragentes)
                    añadir = [id2,nombre,pais]
                    MIMODULO.añadir_al_csv(diragentes,añadir)
                    print("Agente añadido con éxito.\n")

                    usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV
                    agentes = MIMODULO.cargar_csv(diragentes)  # Recarga desde CSV

                case "jugador":
                    
                    posicion =  input("Introduce la posicion del nuevo jugador: ")
                    edad =  input("Introduce la edad del nuevo jugador: ")
                    id2 = MIMODULO.nuevo_id(dirjugadores)
                    añadir = [id2,nombre,posicion,edad,id]
                    MIMODULO.añadir_al_csv(dirjugadores,añadir)
                    print("Jugador añadido con éxito.\n")
                    
                    
                      # Recarga desde CSV
        
        
        
        if opcion == 5: # CAMBIAR O AÑADIR DATOS A UNA PERSONA
            dentrocambios = False
            print("¿Que acción deseas Relizar?") # CAMBIAR O AÑADIR DATOS (ELECCION)
            print("1. Cambiar Datos")
            print("2. Añadir Datos")
            cambiarañadir = int(input("¿Quieres Cambiar, o quieres Añadir datos de una persona?: "))
            while cambiarañadir not in [1, 2]:
                print(f"Error: {cambiarañadir} no es una opción valida.")
                print("1. Cambiar Datos")
                print("2. Añadir Datos")
                cambiarañadir = int(input("¿Quieres Cambiar, o quieres Añadir datos de una persona?: "))
            print("¿De quien quieres modificar un dato?") # BUSQUEDA POR NOMBRE O POR USUARIO (ELECCION)
            vuelta_nom_usu, tipo, nom = Opciones.buscar_nombre_usuario(usuarios)
            idjugador = MIMODULO.obtener_id_por_nombre(dirusuarios,vuelta_nom_usu,tipo,'id')

            
            match cambiarañadir:
                case 1:
                    while dentrocambios == False:
                        print("1. Ojeador Asignado a un Jugador")
                        print("2. Agente Asignado a un Jugador")
                        print("3. Usuario de una Persona")
                        print("4. Nombre de una Persona")
                        print("5. Rol de una persona")
                        print("6. Salir")
                        datoinp = input("¿Que dato quieres cambiar?: ")
                        while datoinp not in ["1","2","3","4","5","6"]:
                            datoinp = input("Caracter no valido: ¿Que dato quieres cambiar?: ")
                        dato = int(datoinp)

                        if dato == 1: # OJEADOR ASIGNADO A UN JUGADOR

                            idjugador = MIMODULO.obtener_id_por_nombre(dirjugadores,nom,'nombre','id')
                            
                            ojeador = input("Nombre del ojeador: ")
                            idojeador = MIMODULO.obtener_id_por_nombre(dirojeadores,ojeador,'nombre','id')
                            
                            if idojeador == None :
                                print(f"Error: {ojeador} no es un ojeador existente.")
                            else:
                                Opciones.modificar_asignacion(asignaciones, dirasignaciones, 'jugadorid', idjugador, idojeador, 'ojeadorid')
                                print(f"Ojeador {ojeador} asignado al jugador {nom}.\n")
                            
                        
                        if dato == 2: # AGENTE ASIGNADO A UN JUGADOR

                            idjugador = MIMODULO.obtener_id_por_nombre(dirjugadores,nom,'nombre','id')

                            agente = input("Nombre del agente: ")
                            idagente = MIMODULO.obtener_id_por_nombre(diragentes,agente,'nombre','id')

                            if idagente == None :
                                print(f"Error: {agente} no es un agente existente.")
                            else:
                                Opciones.modificar_asignacion(asignaciones, dirasignaciones,'jugadorid', idjugador, idagente, 'agenteid')
                                print(f"Agente {agente} asignado al jugador {nom}\n")

                        if dato == 3: # USUARIO DE UNA PERSONA
                            
                            nuevo = input("Nuevo nombre usuario: ")
                            Opciones.modificar_asignacion(usuarios, dirusuarios,'id', idjugador, nuevo, 'usuario')
                        
                            print(f"El usuario asigando a {nom} ahora es {nuevo} \n")

                        if dato == 4: # NOMBRE DE UNA PERSONA
                            
                            nuevo = input("Nuevo nombre: ")
                            Opciones.modificar_asignacion(usuarios, dirusuarios, 'id', idjugador, nuevo, 'nombre')

                        
                            print(f"Nombre asignado a {vuelta_nom_usu} cambiado.\n")

                        if dato == 5: # ROL DE UNA PERSONA
                            
                            nuevo = input("Nuevo rol: ")
                            while nuevo not in ["director","ojeador","agente","jugador"]:
                                print(f"Error: {nuevo} no es un departamento válido.")
                                nuevo = input("Nuevo rol: ")

                            Opciones.modificar_asignacion(usuarios, dirusuarios, 'id', idjugador, nuevo, 'rol')
                            
                            print(f"Rol asignado a {vuelta_nom_usu} cambiado.\n")

                        if dato == 6: 
                            dentrocambios == True
                            print("Saliendo... \n")
                            time.sleep(3)
                            break


                case 2:
                    while dentrocambios == False:
                        idjugador = MIMODULO.obtener_id_por_nombre(dirjugadores,nom,'nombre','id')

                        print("1. Ojeador Asignado a un Jugador")
                        print("2. Agente Asignado a un Jugador")
                        print("3. Salir")
                        datoinp = input("¿Que dato quieres cambiar?: ")
                        while datoinp not in ["1","2","3"]:
                            datoinp = input("Caracter no valido: ¿Que dato quieres cambiar?: ")
                        dato = int(datoinp)


                        if dato == 1: # OJEADOR ASIGNADO A UN JUGADOR                            

                            if Opciones.tiene_valor_asignado(asignaciones, idjugador, 'jugadorid', 'ojeadorid'):
                                print(f"El jugador {vuelta_nom_usu} ya tiene ojeador asignado.")
                            
                            elif Opciones.tiene_valor_asignado(asignaciones, idjugador, 'jugadorid', 'agenteid'):
                            
                                ojeador = input("Nombre del ojeador: ")
                                idojeador = MIMODULO.obtener_id_por_nombre(dirojeadores,ojeador,'nombre','id')
                                
                                if idojeador == None :
                                    print(f"Error: {ojeador} no es un ojeador existente.")
                                else:
                                    Opciones.modificar_asignacion(asignaciones, dirasignaciones, 'jugadorid', idjugador, idojeador, 'ojeadorid')
                                    print(f"Ojeador {ojeador} asignado al jugador {nom}.\n")
                            
                            else:
                                ojeador = input("Nombre del ojeador: ")
                                idojeador = MIMODULO.obtener_id_por_nombre(dirojeadores,ojeador,'nombre','id')

                                Opciones.crear_asignacion(asignaciones, dirasignaciones, idjugador, idojeador=idojeador)
                                
                                print(f"Ojeador {ojeador} asignado al jugador {nom}.\n")
                                
                            asignaciones = MIMODULO.cargar_csv(dirasignaciones)  # Recarga desde CSV

                        if dato == 2: # AGENTE ASIGNADO A UN JUGADOR
                        
                            if Opciones.tiene_valor_asignado(asignaciones, idjugador, 'jugadorid', 'agenteid'):
                                print(f"El jugador {vuelta_nom_usu} ya tiene agente asignado.")
                            
                            elif Opciones.tiene_valor_asignado(asignaciones, idjugador, 'jugadorid', 'ojeadorid'):

                                agente = input("Nombre del agente: ")
                                idagente = MIMODULO.obtener_id_por_nombre(diragentes,agente,'nombre','id')

                                if idagente == None :
                                    print(f"Error: {agente} no es un agente existente.")
                                else:
                                    Opciones.modificar_asignacion(asignaciones, dirasignaciones,'jugadorid', idjugador, idagente, 'agenteid')
                                    print(f"Agente {agente} asignado al jugador {nom}\n")

                            else:
                                agente = input("Nombre del agente: ")
                                idagente = MIMODULO.obtener_id_por_nombre(diragentes,agente,'nombre','id')
                                
                                Opciones.crear_asignacion(asignaciones, dirasignaciones, idjugador, idagente=idagente)
                                print(f"Agente {agente} asignado al jugador {nom}\n")

                            asignaciones = MIMODULO.cargar_csv(dirasignaciones)  # Recarga desde CSV

                        if dato == 3: 
                            dentrocambios == True
                            print("Saliendo...")
                            time.sleep(3)
                            break
                

        if opcion == 6:
            salir = True


# ROL: OJEADOR

elif fila_usuario['rol'] == 'ojeador':

    while salir == False:
        print("1. Ver mis jugadores asignados")
        print("2. Añadir nuevo Jugador")
        print("3. Salir")
        inpopcion = int(input("Que opción te gustaría utilizar? "))
        opcion = int(inpopcion)
        if opcion == 1: # VER JUGADORES ASIGNADOS

            Opciones.buscar_ojeador(fila_usuario)
        
        if opcion == 2:
            print("AÑADIR UN NUEVO JUGADOR")

            id, nombre, usuario, contraseña = Opciones.añadir_persona()
            añadir = (id,nombre,usuario,contraseña,'jugador')
            MIMODULO.añadir_al_csv(dirusuarios, añadir)
            posicion =  input("Introduce la posicion del nuevo jugador: ")
            edad =  input("Introduce la edad del nuevo jugador: ")
            while not edad.isdigit():
                print("La edad introducida no es valida")
                edad =  input("Introduce la edad del nuevo jugador: ")
            id2 = MIMODULO.nuevo_id(jugadores)
            añadir = [id2,nombre,posicion,edad,id]
            MIMODULO.añadir_al_csv(dirjugadores,añadir)
            añadir = [MIMODULO.nuevo_id(dirasignaciones),id2,(MIMODULO.obtener_id_por_nombre(dirojeadores, usu,'nombre', 'id'))]
            MIMODULO.añadir_al_csv(dirasignaciones,añadir)
            
            
            print("Jugador añadido con éxito.")

            usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV
            jugadores = MIMODULO.cargar_csv(dirjugadores)  # Recarga desde CSV
            asignaciones = MIMODULO.cargar_csv(dirasignaciones)  # Recarga desde CSV

        if opcion == 3:
            salir == True
            break

# ROL: AGENTE

elif fila_usuario['rol'] == 'agente':
    añadir = []
    
    print("JUGADORES QUE GESTIONO")
    
    # Buscar todos los jugadores que gestiona este agente
    Opciones.buscar_agente(fila_usuario)

# ---------------------------------------------
# ROL: JUGADOR
# ---------------------------------------------
elif fila_usuario['rol'] == 'jugador':
    añadir = []
    while salir == False:
        print("1. Ver Tus Datos")
        print("2. Cambiar Datos")
        print("3. Salir")
        cambiarañadir = input("¿Quieres ver tus datos o cambiar alguno?: ")
        while cambiarañadir not in ["1", "2", "3"]:
            print(f"Error: {cambiarañadir} no es una opción valida.")
            print("1. Ver Tus Datos")
            print("2. Cambiar Datos")
            print("3. Salir")
            cambiarañadir = int(input("¿Quieres ver tus datos o cambiar alguno?: "))
        

        match int(cambiarañadir):
            case 1:
        
                print("MIS DATOS PERSONALES")

                nombre = MIMODULO.obtener_id_por_nombre(dirusuarios,usu,"usuario","nombre")

                Opciones.buscar_jugador(fila_usuario)
                for jugador in jugadores:
                    if jugador["nombre"].lower() == nombre.lower():
                        Opciones.ver_jugador_jugador(jugador)
                        break


            case 2:
                print("1. Usuario")
                print("2. Nombre")
                print("3. Contraseña")
                print("4. Posición")
                print("5. Edad")
                idusu = MIMODULO.obtener_id_por_nombre(dirusuarios,usu,'usuario','id')
                idjugador = MIMODULO.obtener_id_por_nombre(dirjugadores,idusu,'userid','id')
             
                
                seleccion = input("¿Que dato quieres cambiar?: ")
                while seleccion not in ["1", "2", "3", "4" ,"5"]:
                    print(f"Error: {seleccion} no es una opción valida.")
                    seleccion = input("¿Que dato quieres cambiar alguno?: ")
                
                match int(seleccion):
                    case 1: # MODIFICAR USUARIO
                    
                        nuevo = input("Nuevo nombre usuario: ")
                        Opciones.modificar_asignacion(usuarios, dirusuarios,'id', idusu, nuevo, 'usuario')
                        jugadores = MIMODULO.cargar_csv(dirjugadores)  # Recarga desde CSV
                        usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV
                        usu = nuevo
                
                    case 2: # MODIFICAR NOMBRE
                    
                        nuevo = input("Nuevo nombre: ")
                        Opciones.modificar_asignacion(usuarios, dirusuarios, 'id', idusu, nuevo, 'nombre')
                        Opciones.modificar_asignacion(jugadores, dirjugadores, 'id', idjugador, nuevo, 'nombre')
                        jugadores = MIMODULO.cargar_csv(dirjugadores)  # Recarga desde CSV
                        usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV
                    
                    case 3:
                        nuevo = input("Nueva Contraseña: ")
                        Opciones.modificar_asignacion(usuarios, dirusuarios, 'id', idusu, nuevo, 'contraseña')
                        jugadores = MIMODULO.cargar_csv(dirjugadores)  # Recarga desde CSV
                        usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV
                    
                    case 4:
                        nuevo = input("Nueva Posición: ")
                        Opciones.modificar_asignacion(jugadores, dirjugadores, 'id', idjugador, nuevo, 'posicion')
                        jugadores = MIMODULO.cargar_csv(dirjugadores)  # Recarga desde CSV
                        usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV

                    case 5:
                        nuevo = input("Edad: ")
                        Opciones.modificar_asignacion(jugadores, dirjugadores, 'id', idjugador, nuevo, 'edad')
                        jugadores = MIMODULO.cargar_csv(dirjugadores)  # Recarga desde CSV
                        usuarios = MIMODULO.cargar_csv(dirusuarios)  # Recarga desde CSV

            case 3:
                salir == True
                break

print("Gracias por usar el sistema. ¡Hasta pronto!")
