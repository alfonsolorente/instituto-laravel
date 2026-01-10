# Instrucciones de Instalación y Ejecución - Instituto App

Este archivo contiene las instrucciones para desplegar la aplicación entregada en el ZIP.

## Requisitos Previos
- PHP >= 8.1
- Composer
- MySQL (XAMPP o similar)
- Node.js & NPM (opcional, para compilar assets si se modifican)

## Pasos de Instalación

1.  **Descomprimir**: Extraiga el archivo ZIP en su directorio de servidor web o carpeta de proyectos.
2.  **Dependencias**: Abra una terminal en la carpeta del proyecto y ejecute:
    ```bash
    composer install
    ```
3.  **Configuración (.env)**:
    - El archivo `.env` ya está incluido y configurado para funcionar.
    - Asegúrese de que su servidor MySQL esté corriendo en el puerto 3306.
    - La configuración asume usuario `root` sin contraseña. Si su MySQL tiene contraseña, edite el archivo `.env`.

4.  **Base de Datos**:
    - Cree una base de datos llamada `instituto` en su gestor MySQL (phpMyAdmin, etc.).
    - Ejecute las migraciones para crear las tablas:
      ```bash
      php artisan migrate
      ```
      *Nota: Si ya tiene datos, no es necesario ejecutar `migrate` a menos que quiera reiniciar las tablas.*

5.  **Usuario Administrador**:
    - Si la base de datos está vacía, puede crear el usuario administrador ejecutando:
      ```bash
      php artisan tinker
      ```
      Y luego pegue:
      ```php
      \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@instituto.com', 'password' => bcrypt('password')]);
      exit
      ```

6.  **Ejecutar**:
    - Inicie el servidor de desarrollo:
      ```bash
      php artisan serve
      ```
    - Acceda a `http://127.0.0.1:8000` (o el puerto que indique la consola).

## Credenciales de Acceso
- **Email**: `admin@instituto.com`
- **Contraseña**: `password`

## Notas Importantes
- La aplicación está configurada para usar **archivos** para sesiones y caché (`SESSION_DRIVER=file`, `CACHE_STORE=file`) para simplificar el despliegue y evitar tablas innecesarias en la base de datos.
- Solo se utilizan las tablas `users` y `estudiantes` en la base de datos.
