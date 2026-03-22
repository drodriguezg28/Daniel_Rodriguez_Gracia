# utilidades_personales.py
from datetime import datetime
import os
    
def calcular_edad(fecha_nacimiento: str) -> int:
    """
    Calcula la edad en años a partir de una fecha de nacimiento (dd/mm/yyyy).
    """
    nacimiento = datetime.strptime(fecha_nacimiento, "%d/%m/%Y")
    hoy = datetime.today()

    edad = hoy.year - nacimiento.year
    if (hoy.month, hoy.day) < (nacimiento.month, nacimiento.day):
        edad -= 1
    return edad


def dia_en_que_naci(fecha_nacimiento: str) -> str:
    """
    Devuelve el día de la semana en que naciste.
    """
    dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"]
    nacimiento = datetime.strptime(fecha_nacimiento, "%d/%m/%Y")
    numero_dia = nacimiento.weekday()  # 0 = Lunes, 6 = Domingo
    return dias[numero_dia]


def longitud_nombre(nombre: str) -> int:
    """
    Devuelve la cantidad de caracteres en un nombre (sin contar espacios).
    """
    nombre_sin_espacios = nombre.replace(" ", "")
    return len(nombre_sin_espacios)


def contar_caracter(nombre: str, caracter: str) -> int:
    """
    Cuenta cuántas veces aparece un carácter específico en el nombre.
    No distingue mayúsculas de minúsculas.
    """
    return nombre.lower().count(caracter.lower())

def comprobar_dni(dni: str) -> bool:
    dni = dni.upper()
    letras = "TRWAGMYFPDXBNJZSQVHLCKE"
    numero = int(dni[:8])
    letra_correcta = letras[numero % 23]
    if dni[-1] == letra_correcta:
        return True
    else:
        return False


def comprobar_fecha(fecha) :
    
    if fecha.count("/") != 2 or len(fecha) != 10:
        return False
    fecha = fecha.strip()
    dia, mes, año= fecha.split("/")
    dia =int(dia)
    mes =int(mes)
    año =int(año)

    # primera_barra = fecha.find("/")
    # segunda_barra = fecha.find("/", primera_barra+1)
    # dia = int(fecha[:primera_barra])
    # mes = int(fecha[primera_barra+1:segunda_barra])
    # año = int(fecha[segunda_barra+1:])

    
    if dia < 1 or dia > 31 or mes < 1 or mes > 12 or año < 1000 or año > 2025 :
        return False

    if mes in (4,6,9,11) and dia >= 30:
        return False
    bisiesto = (año % 4 == 0 and año % 100 != 0) or (año % 400 == 0)
    if mes == 2:
        if bisiesto and dia > 29:
           return False 
        if not bisiesto and dia > 28:
            return False


    if mes in (1, 3, 5, 7, 8, 10, 12) and dia > 31:
        return False
    if año > 2025:
        return False
    
    return True

def comprobarvocales(cadena):
    for letra in cadena:
        if letra.lower() in "aeiou":
            return True
    return False    

    

def comprob_2apellidos(apellidos):
    
    apellidos = apellidos.strip()
    partes = apellidos.split()
    if len(partes) < 2:
        return "1ape"
    apellido1, apellido2 = apellidos.split()
    if len(apellidos) == 2:
        return True
    else:
        return False
    

def calcular_tiempo(fecha):
    hoy = datetime.today()
    edad = hoy.year - fecha.year
    if (hoy.month, hoy.day) < (fecha.month, fecha.day):
        edad -= 1
    return edad


###############
# EXCEPTIONS ##
###############

# Chequear que un dato es numérico
def validar_numerico(dato):
    try:
        numero = float(dato)
        print(f"El dato '{dato}' es numérico: {numero}")
        return numero
    except ValueError:
        print(f"Error: '{dato}' no es un dato numérico")
        return None
    

# Chequear que no es cero para dividir
def dividir_cero(dividendo, divisor):
    try:
        resultado = dividendo / divisor
        print(f"Resultado: {dividendo} / {divisor} = {resultado}")
        return resultado
    except ZeroDivisionError:
        print("Error: No se puede dividir por cero")
        return None


# Chequear es numero y es divisible

def division_numerico(dividendo, divisor):
    try:
        # Validar que ambos sean numéricos
        div = float(dividendo)
        divr = float(divisor)
        
        # Intentar la división
        resultado = div / divr
        print(f"Resultado: {div} / {divr} = {resultado}")
        return resultado
        
    except ValueError:
        print("Error: Uno o ambos valores no son numéricos")
        return None
    except ZeroDivisionError:
        print("Error: El divisor no puede ser cero")
        return None


# Chequear acceso a elemento de lista
def acceder_lista(lista, indice):
    try:
        elemento = lista[indice]
        print(f"Elemento en posición {indice}: {elemento}")
        return elemento
    except IndexError:
        print(f"Error: El índice {indice} está fuera de rango. La lista tiene {len(lista)} elementos")
        return None


# Chequear error de tipo de datos
def sumar_elementos(a, b):
    try:
        resultado = a + b
        print(f"Suma: {a} + {b} = {resultado}")
        return resultado
    except TypeError as e:
        print(f"Error de tipo: {e}")
        print(f"No se pueden sumar {type(a).__name__} y {type(b).__name__}")
        return None


# Chequear que un fichero existe y se puede leer
def leer_fichero(nombre_fichero):
    # Verificar existencia
    if not os.path.exists(nombre_fichero):
        print(f"Error: El fichero '{nombre_fichero}' no existe")
        return None
    
    # Intentar leer el fichero
    try:
        with open(nombre_fichero, 'r', encoding='utf-8') as archivo:
            contenido = archivo.read()
            print(f"Fichero leído correctamente ({len(contenido)} caracteres)")
            return contenido
    except PermissionError:
        print(f"Error: No tienes permisos para leer '{nombre_fichero}'")
        return None
    except IOError as e:
        print(f"Error de E/S al leer el fichero: {e}")
        return None




#EXTRA EXTRA EXTRA EXTRA

def verificar_login(usuario_ingresado, contrasena_ingresada, usuarios):
    for u in usuarios:
        if u['usuario'] == usuario_ingresado:
            if u['contraseña'] == contrasena_ingresada:
                return u
            else:
                print("Usuario o contraseña incorrecta")
                return None
    print("Usuario o contraseña incorrecta")
    return None

import csv
def cargar_csv(nombre_archivo):
    datos = []
    with open(nombre_archivo, newline='', encoding='utf-8') as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            datos.append(row)
    return datos


def nuevo_id(lista, campo='id'):
    """
    Genera el siguiente ID disponible en una lista de diccionarios
    """
    if not lista:
        return 1
    
    # Extraer todos los IDs existentes
    ids_existentes = [int(item[campo]) for item in lista if item.get(campo)]
    
    # Encontrar el siguiente ID disponible
    nuevo_id = 1
    while nuevo_id in ids_existentes:
        nuevo_id += 1
    
    return nuevo_id

import Opciones

def añadir_al_csv(archivo,nueva_fila):
    with open(archivo, 'a', newline='', encoding='utf-8') as f:
        writer = csv.writer(f)
        writer.writerow(nueva_fila)
    Opciones.recargar_todas_listas()

def obtener_id_por_nombre(ruta_csv, nombre_buscado, buscarpor, encontrar):
    # ej: (ruta_csv, daniel, usuario, id)
    with open(ruta_csv, mode='r', encoding='utf-8') as archivo:
        lector = csv.DictReader(archivo) # Usar DictReader facilita buscar por nombre de columna
        for fila in lector:
            if fila[buscarpor].strip().lower() == nombre_buscado.strip().lower():
                return fila[encontrar]
    return None # Si no lo encuentra

class Inmobiliaria:
    # la clase inmobiliaria estará formada por una lista de objetos inmuebles
    def __init__(self):
        self.inmuebles = []

    def agregar_inmueble(self, inmueble):
        self.inmuebles.append(inmueble)
        print("✅ Inmueble agregado correctamente.")

    def listar_inmuebles(self):
        if not self.inmuebles:
            print("⚠ No hay inmuebles registrados.")
        else:
            for inmueble in self.inmuebles:
                print(inmueble)

    def buscar_por_tipo(self, tipo):
        resultados = []
