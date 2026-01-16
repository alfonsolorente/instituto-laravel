<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Nombre de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor es el nombre de su aplicación, que se utilizará cuando el
    | framework necesite colocar el nombre de la aplicación en una notificación
    | u otros elementos de la interfaz de usuario.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Entorno de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Este valor determina el "entorno" en el que se ejecuta actualmente su
    | aplicación. Esto puede determinar cómo prefiere configurar varios
    | servicios que utiliza la aplicación. Configúrelo en su archivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo de Depuración de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Cuando su aplicación está en modo de depuración, se mostrarán mensajes
    | de error detallados con trazas de pila en cada error que ocurra.
    | Si está deshabilitado, se muestra una página de error genérica simple.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Esta URL es utilizada por la consola para generar URLs correctamente
    | cuando se utiliza la herramienta de línea de comandos Artisan. Debe
    | establecer esto a la raíz de la aplicación para Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Zona Horaria de la Aplicación
    |--------------------------------------------------------------------------
    |
    | Aquí puede especificar la zona horaria predeterminada para su aplicación,
    | que será utilizada por las funciones de fecha y hora de PHP.
    | Por defecto, está configurada en "UTC".
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Configuración regional de la aplicación (Idioma)
    |--------------------------------------------------------------------------
    |
    | El idioma de la aplicación determina el idioma predeterminado que será
    | utilizado por los métodos de traducción / localización de Laravel.
    |
    */

    'locale' => env('APP_LOCALE', 'es'),
    
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'es'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Clave de Encriptación
    |--------------------------------------------------------------------------
    |
    | Esta clave es utilizada por los servicios de encriptación de Laravel y
    | debe ser una cadena aleatoria de 32 caracteres. Debe configurar esto
    | antes de desplegar la aplicación.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Controlador del Modo de Mantenimiento
    |--------------------------------------------------------------------------
    |
    | Estas opciones determinan el controlador utilizado para gestionar el
    | estado del "modo de mantenimiento" de Laravel.
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

];
