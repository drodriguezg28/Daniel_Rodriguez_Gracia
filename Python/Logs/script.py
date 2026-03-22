import tkinter as tk
from tkinter import scrolledtext
from tkinter import messagebox              # Para mostrar ventanas de alerta/confirmación
import subprocess
import re
import os


RUTA_SCRIPT = os.path.join(os.path.dirname(os.path.abspath(__file__)), "script_modif.sh")

# Colores que usaremos en la interfaz
COLOR_FONDO        = "#1e1e2e"
COLOR_PANEL        = "#2a2a3e"
COLOR_BOTON        = "#3a3a5c"
COLOR_BOTON_HOVER  = "#5a5a8c"
COLOR_TEXTO        = "#cdd6f4"
COLOR_TITULO       = "#89b4fa"
COLOR_VERDE        = "#a6e3a1"
COLOR_ROJO         = "#f38ba8"
COLOR_AMARILLO     = "#f9e2af"



def limpiar_ansi(texto):
    patron_ansi = re.compile(r'\033\[[0-9;]*m')
    return patron_ansi.sub('', texto)



def ejecutar_script(opciones_entrada, cuadro_texto, boton):

    cuadro_texto.config(state=tk.NORMAL)
    cuadro_texto.delete("1.0", tk.END)
    cuadro_texto.insert(tk.END, "⏳ Ejecutando...\n\n")
    cuadro_texto.config(state=tk.DISABLED)

    boton.config(state=tk.DISABLED)


    def tarea_en_segundo_plano():
        try:
            # Verificamos que el script existe antes de ejecutarlo
            if not os.path.exists(RUTA_SCRIPT):
                mostrar_error(cuadro_texto, f"No se encontró el script en:\n{RUTA_SCRIPT}")
                boton.config(state=tk.NORMAL)
                return

            
            # stdin=subprocess.PIPE  → le podemos escribir entradas automáticamente
            # stdout=subprocess.PIPE → capturamos lo que imprime
            # stderr=subprocess.PIPE → capturamos también los mensajes de error
            proceso = subprocess.Popen(
                ["bash", RUTA_SCRIPT],
                stdin=subprocess.PIPE,
                stdout=subprocess.PIPE,
                stderr=subprocess.PIPE,
                text=True
            )

            salida, errores = proceso.communicate(input=opciones_entrada, timeout=15)

            salida_limpia  = limpiar_ansi(salida)
            errores_limpios = limpiar_ansi(errores)

            resultado_final = salida_limpia
            if errores_limpios.strip():
                resultado_final += f"\n--- ERRORES ---\n{errores_limpios}"

            mostrar_resultado(cuadro_texto, resultado_final)

        except subprocess.TimeoutExpired:
            proceso.kill()
            mostrar_error(cuadro_texto, "El script tardó demasiado y fue detenido.")

        except PermissionError:
            mostrar_error(cuadro_texto, "Sin permisos para ejecutar el script.\nIntenta ejcutar con sudo")

        except Exception as error:
            mostrar_error(cuadro_texto, f"Error:\n{str(error)}")

        finally:
            boton.config(state=tk.NORMAL)

    tarea_en_segundo_plano()

def mostrar_resultado(cuadro_texto, texto):
    cuadro_texto.config(state=tk.NORMAL)
    cuadro_texto.delete("1.0", tk.END)
    cuadro_texto.insert(tk.END, texto)
    cuadro_texto.config(state=tk.DISABLED)
    cuadro_texto.see(tk.END)


def mostrar_error(cuadro_texto, mensaje):
    cuadro_texto.config(state=tk.NORMAL)
    cuadro_texto.delete("1.0", tk.END)
    cuadro_texto.insert(tk.END, mensaje)
    cuadro_texto.config(state=tk.DISABLED)



def crear_boton(padre, texto, comando, color_fondo=COLOR_BOTON):
    boton = tk.Button(
        padre,
        text=texto,
        command=comando,
        bg=color_fondo,             
        fg=COLOR_TEXTO,
        relief=tk.FLAT,
        padx=12,
        pady=8,
        activeforeground=COLOR_TEXTO,
        borderwidth=0,
        highlightthickness=1,
    )

    return boton



def crear_ventana():

    # --- Creamos la ventana principal ---
    ventana = tk.Tk()
    ventana.title("🖥️  Administrador de Logs del Sistema")
    ventana.geometry("900x650")                
    ventana.configure(bg=COLOR_FONDO)

    # --- TÍTULO PRINCIPAL ---
    marco_titulo = tk.Frame(ventana, bg=COLOR_FONDO, pady=15)

    tk.Label(
        marco_titulo,
        text="ADMINISTRADOR DE LOGS",
        font=("Courier", 18, "bold"),
        fg=COLOR_TITULO,
        bg=COLOR_FONDO
    ).pack()

    tk.Label(
        marco_titulo,
        text="Interfaz gráfica",
        font=("Courier", 9),
        fg="#6c7086",
        bg=COLOR_FONDO
    ).pack()

    # --- SEPARADOR HORIZONTAL ---
    tk.Frame(ventana, height=1, bg=COLOR_BOTON_HOVER).pack(fill=tk.X, padx=20)

    # --- MARCO PRINCIPAL (divide en izquierda/derecha) ---
    marco_principal = tk.Frame(ventana, bg=COLOR_FONDO)
    marco_principal.pack(fill=tk.BOTH, expand=True, padx=15, pady=10)

    # ---- PANEL IZQUIERDO ----
    panel_botones = tk.Frame(marco_principal, bg=COLOR_PANEL, width=210, padx=10, pady=10)
    panel_botones.pack(side=tk.LEFT, fill=tk.Y, padx=(0, 10))
    panel_botones.pack_propagate(False)

    tk.Label(
        panel_botones,
        text="📋 OPCIONES",
        font=("Courier", 11, "bold"),
        fg=COLOR_TITULO,
        bg=COLOR_PANEL
    ).pack(pady=(5, 15))

    # ---- PANEL DERECHO ----
    panel_salida = tk.Frame(marco_principal, bg=COLOR_PANEL, padx=10, pady=10)
    panel_salida.pack(side=tk.LEFT, fill=tk.BOTH, expand=True)

    tk.Label(
        panel_salida,
        text="📄 SALIDA DEL SISTEMA",
        font=("Courier", 11, "bold"),
        fg=COLOR_TITULO,
        bg=COLOR_PANEL
    ).pack(anchor=tk.W, pady=(0, 8))

    # Cuadro de texto con scroll donde se muestra la salida del script
    cuadro_salida = scrolledtext.ScrolledText(
        panel_salida,
        wrap=tk.WORD,
        state=tk.DISABLED,
        font=("Courier", 9),
        bg="#11111b",
        fg=COLOR_TEXTO,
        insertbackground=COLOR_TEXTO,
        relief=tk.FLAT,
        padx=8,
        pady=8
    )
    cuadro_salida.pack(fill=tk.BOTH, expand=True)

    # Mensaje inicial en el cuadro de salida
    cuadro_salida.config(state=tk.NORMAL)
    cuadro_salida.insert(tk.END,
        "Bienvenido al Administrador de Logs.\n\n"
        "Selecciona una opción del panel izquierdo\n"
        "para ver la información del sistema.\n\n"
        f"Script conectado: {RUTA_SCRIPT}"
    )
    cuadro_salida.config(state=tk.DISABLED)

  
    btn_syslog = crear_boton(
        panel_botones,
        "Analizar Syslog",
        lambda: ejecutar_script("1\n\n5\n", cuadro_salida, btn_syslog) #opción 1, enter, enter, opción 5(salir) enter
    )  
    btn_syslog.pack(fill=tk.X, pady=4)

    btn_auth = crear_boton(
        panel_botones,
        "Analizar Auth.log",
        lambda: ejecutar_script("2\n\n5\n", cuadro_salida, btn_auth)
    )
    btn_auth.pack(fill=tk.X, pady=4)

    btn_errores = crear_boton(
        panel_botones,
        "Errores Críticos",
        lambda: ejecutar_script("3\n\n5\n", cuadro_salida, btn_errores),
        color_fondo="#5c3a3a"
    )
    btn_errores.pack(fill=tk.X, pady=4)

    tk.Frame(panel_botones, height=1, bg=COLOR_BOTON_HOVER).pack(fill=tk.X, pady=10)
    tk.Label(
        panel_botones,
        text="⚠️  Gestión de Logs",
        font=("Courier", 8),
        fg=COLOR_AMARILLO,
        bg=COLOR_PANEL
    ).pack(pady=(0, 4))


    btn_rotar_sys = crear_boton(
        panel_botones,
        "Rotación de Syslog",
        lambda: confirmar_y_rotar("4\n1\n\n5\n", cuadro_salida, btn_rotar_sys, "Syslog"),
        color_fondo="#5c4a1e"
    )
    btn_rotar_sys.pack(fill=tk.X, pady=4)

    btn_rotar_auth = crear_boton(
        panel_botones,
        "Rotación de Auth.log",
        lambda: confirmar_y_rotar("4\n2\n\n5\n", cuadro_salida, btn_rotar_auth, "Auth.log"),
        color_fondo="#5c4a1e"
    )
    btn_rotar_auth.pack(fill=tk.X, pady=4)

    tk.Frame(panel_botones, height=1, bg=COLOR_BOTON_HOVER).pack(fill=tk.X, pady=10)

    btn_salir = crear_boton(
        panel_botones,
        "❌  Salir",
        ventana.destroy,
        color_fondo="#3a1e1e"
    )
    btn_salir.pack(fill=tk.X, pady=4, side=tk.BOTTOM)


    def confirmar_y_rotar(opciones, cuadro, boton, nombre_log):
        confirmado = messagebox.askyesno(
            title="⚠️ Confirmar Rotación",
            message=f"¿Estás seguro de que quieres rotar {nombre_log}?\n\nEsta acción vaciará el archivo de log.\nSe creará una copia de seguridad automáticamente."
        )

        if confirmado:
            ejecutar_script(opciones, cuadro, boton)

    barra_estado = tk.Frame(ventana, bg="#11111b", pady=4)
    barra_estado.pack(fill=tk.X, side=tk.BOTTOM)

    tk.Label(
        barra_estado,
        text=f"  Script: {RUTA_SCRIPT}",
        font=("Courier", 8),
        fg="#6c7086",
        bg="#11111b",
        anchor=tk.W
    ).pack(side=tk.LEFT, padx=10)

    tk.Label(
        barra_estado,
        text="Requiere permisos sudo para algunas operaciones  ",
        font=("Courier", 8),
        fg="#6c7086",
        bg="#11111b"
    ).pack(side=tk.RIGHT)

    ventana.mainloop()


crear_ventana()