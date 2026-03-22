#!/bin/bash

# Colores
ROJO='\033[0;31m'
VERDE='\033[0;32m'
AMARILLO='\033[1;33m'
CIAN='\033[0;36m'
CERRAR='\033[0m'

# Archivos
LOG_AUTH="/var/log/auth.log"
LOG_SYSLOG="/var/log/syslog"

# --- FUNCIONES ---

formatear_fecha() {
    local linea="$1"
    local fecha
    fecha=$(echo "$linea" | cut -d'.' -f1)
    date -d "$fecha" +"%d/%m/%Y %H:%M" 2>/dev/null || echo "Fecha desconocida"
}

analizar_linea_auth() {
    local linea="$1"
    local fecha
    local proceso
    local mensaje

    fecha=$(formatear_fecha "$linea")
    
    # Extraer el proceso
    proceso=$(echo "$linea" | cut -d' ' -f5 | tr -d ':')
    if [[ $proceso == "*TTY*" ]]; then
        proceso=$(echo "$linea" | cut -d' ' -f2,11 | tr -d ':')
    elif [[ "$proceso" == "*sshd*"  ]]; then
    
        proceso=$(echo "$linea" | cut -d' ' -f2,11 | tr -d ':')

    fi
    # Extraer el mensaje
    mensaje=$(echo "$linea" | cut -d' ' -f6-)

    # Resaltar errores en rojo
    if [[ "$mensaje" =~ "error" || "$mensaje" =~ "failed" || "$mensaje" =~ "CRITICAL" ]]; then
        printf "${CIAN}%-18s${CERRAR} | ${AMARILLO}%-17s${CERRAR} | ${ROJO}%s${CERRAR}\n" "$fecha" "$proceso" "$mensaje"
    else
        printf "${CIAN}%-18s${CERRAR} | ${AMARILLO}%-17s${CERRAR} | %s\n" "$fecha" "$proceso" "$mensaje"
    fi
}
analizar_linea_sys() {
    local linea="$1"
    local fecha
    local proceso
    local mensaje

    fecha=$(formatear_fecha "$linea")
    
    # Extraer el proceso
    proceso=$(echo "$linea" | cut -d' ' -f5 | tr -d ':')
    
    # Extraer el mensaje
    mensaje=$(echo "$linea" | cut -d' ' -f6-)

    # Resaltar errores en rojo
    if [[ "$mensaje" =~ "error" || "$mensaje" =~ "failed" || "$mensaje" =~ "CRITICAL" ]]; then
        printf "${CIAN}%-18s${CERRAR} | ${AMARILLO}%-17s${CERRAR} | ${ROJO}%s${CERRAR}\n" "$fecha" "$proceso" "$mensaje"
    else
        printf "${CIAN}%-18s${CERRAR} | ${AMARILLO}%-17s${CERRAR} | %s\n" "$fecha" "$proceso" "$mensaje"
    fi
}

procesar_archivo() {
    local archivo="$1"
    if [ -f "$archivo" ]; then
        echo -e "${VERDE}Analizando las últimas 50 entradas de: $archivo${CERRAR}\n"
        printf "${VERDE}%-18s | %-17s | %s${CERRAR}\n" "FECHA Y HORA" "PROCESO" "SUCESO"
        echo "--------------------------------------------------------------------------------"
        
        # Leemos el archivo y lo procesamos línea a línea
        tail -n 50 "$archivo" | while read -r linea; do
            analizar_linea_"$2" "$linea"
        done
    else
        echo -e "${ROJO}Error: El archivo $archivo no existe.${CERRAR}"
    fi
    read -p "Presiona Enter para continuar..."
}

logrotate_logs() {
    local log_file="$1"
    echo -e "${AMARILLO}Iniciando gestión de logs para: $log_file${CERRAR}"

    # 1. Intentar usar logrotate del sistema
    if command -v logrotate &> /dev/null && [ -f "/etc/logrotate.d/rsyslog" ]; then
        echo "Usando configuración de logrotate del sistema..."
        sudo logrotate -f /etc/logrotate.d/rsyslog
        echo -e "${VERDE}¡Rotación completada vía logrotate!${CERRAR}"
    else
        # 2. Rotación Manual (Fallback)
        echo "Logrotate no disponible o sin config. Iniciando rotación manual segura..."
        if [ -f "$log_file" ]; then
            timestamp=$(date +%Y%m%d-%H%M%S)
            sudo cp "$log_file" "${log_file}.${timestamp}.bak"
            sudo truncate -s 0 "$log_file" # Corregido: truncate en lugar de truCERRARate
            
            # Notificar al sistema para que siga escribiendo
            sudo systemctl reload rsyslog 2>/dev/null
            echo -e "${VERDE}Copia de seguridad creada: ${log_file}.${timestamp}.bak${CERRAR}"
            echo -e "${VERDE}Archivo original vaciado.${CERRAR}"
        fi
    fi
    
    # Comprobación de que está vacío
    echo -e "\n${AMARILLO}Estado actual del log:${CERRAR}"
    ls -lh "$log_file"
    read -p "Presiona Enter para continuar..."
}

# --- MENÚ PRINCIPAL ---

while true; do
    clear
    read -p "Seleccione una opción [1-5]: " opcion

    case $opcion in
        1) procesar_archivo "$LOG_SYSLOG" "sys";;
        2) procesar_archivo "$LOG_AUTH" "auth";;
        3)
            echo -e "${ROJO}Buscando errores recientes (últimas 20 líneas)...${CERRAR}"
            grep -iE "error|critical|failed|panic" "$LOG_SYSLOG" | tail -n 20
            read -p "Presiona Enter para continuar..."
            ;;
        4)
            read -p "Elija qué log rotar: " rotar
            case $rotar in
                1) logrotate_logs "$LOG_SYSLOG" ;;
                2) logrotate_logs "$LOG_AUTH" ;;
                3) ;;
                *) echo "Opción no válida" ;;
            esac
            ;;
        5)
            exit 0
            ;;
        *)
            echo -e "${ROJO}Opción no válida.${CERRAR}"
            sleep 1
            ;;
    esac
done