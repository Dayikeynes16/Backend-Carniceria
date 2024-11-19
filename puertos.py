import serial

puerto = '/dev/tty.usbserial-110'  # Usa /dev/tty en lugar de /dev/cu
velocidad = 9600
timeout = 2

try:
    ser = serial.Serial(puerto, velocidad, timeout=timeout)
    print(f"Conexión establecida en {puerto}")
    ser.close()
    print("Conexión serial cerrada con éxito")
except serial.SerialException as e:
    print(f"Error con el puerto serial: {e}")
except Exception as e:
    print(f"Error inesperado: {e}")