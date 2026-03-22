import Anterior.MIMODULO as MIMODULO
usuarios = MIMODULO.cargar_csv("c:/archivospy/proyecto/usuarios.csv")
dirusuarios = "c:/archivospy/proyecto/usuarios.csv"
añadir = []


# id = MIMODULO.contador_lineas("c:/archivospy/proyecto/usuarios.csv") + 1
# nombre = input("Introduce el nombre del nuevo integrante: ")
# usuario = input("Introduce el usuario del nuevo integrante: ")
# contraseña = input("Introduce la contraseña del nuevo integrante: ")
# zona =  input("Introduce la zona del nuevo ojeador: ")
# añadir.append([id,nombre,usuario,contraseña,"ojeador"])
# MIMODULO.añadir_al_csv("c:/archivospy/proyecto/usuarios.csv",añadir[0])

print(MIMODULO.contador_lineas(dirusuarios))