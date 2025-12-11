# Instituto - Sistema de Gestión de Alumnos

Aplicación web desarrollada con Laravel para la gestión de alumnos de un sistema educativo.

## Características

- **Landing Page pública** con información del sistema
- **Sistema de autenticación** (login/logout) con Laravel Breeze
- **Dashboard privado** con tarjetas de navegación
- **CRUD completo de alumnos** (Crear, Leer, Actualizar, Eliminar)
- **Soporte multiidioma** (Español/Inglés)
- **Diseño responsive** con TailwindCSS y DaisyUI

## Requisitos

- PHP >= 8.2
- Composer
- Node.js y npm
- MySQL o SQLite

## Instalación

### 1. Clonar el repositorio
```bash
git clone <url-del-repositorio>
cd instituto
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de Node.js
```bash
npm install
```

### 4. Configurar el entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar la base de datos
Editar el archivo `.env` con los datos de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=instituto
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```

### 7. Compilar assets
```bash
npm run build
```

### 8. Iniciar el servidor de desarrollo
```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## Usuario de prueba

- **Email:** admin@instituto.com
- **Contraseña:** password

## Comandos Artisan utilizados

```bash
# Crear el proyecto Laravel
composer create-project laravel/laravel instituto

# Instalar Laravel Breeze para autenticación
composer require laravel/breeze --dev
php artisan breeze:install blade

# Crear modelo, migración, factory y seeder de Alumno
php artisan make:model Alumno -mfs

# Crear controlador de Alumno con recursos
php artisan make:controller AlumnoController --resource

# Crear middleware para idioma
php artisan make:middleware SetLocale

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Refrescar migraciones con seeders
php artisan migrate:fresh --seed

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Listar rutas
php artisan route:list

# Compilar assets para producción
npm run build

# Compilar assets en modo desarrollo
npm run dev
```

## Estructura del proyecto

```
instituto/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── AlumnoController.php
│   │   └── Middleware/
│   │       └── SetLocale.php
│   └── Models/
│       └── Alumno.php
├── database/
│   ├── factories/
│   │   └── AlumnoFactory.php
│   ├── migrations/
│   │   └── 2025_01_01_000003_create_alumnos_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── lang/
│   ├── en/
│   │   └── messages.php
│   └── es/
│       └── messages.php
├── resources/
│   └── views/
│       ├── alumnos/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── components/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard.blade.php
│       └── welcome.blade.php
└── routes/
    └── web.php
```

## Rutas principales

| Método | URI | Acción | Descripción |
|--------|-----|--------|-------------|
| GET | / | welcome | Landing Page |
| GET | /login | login | Formulario de login |
| POST | /login | authenticate | Autenticar usuario |
| POST | /logout | logout | Cerrar sesión |
| GET | /dashboard | dashboard | Panel de control |
| GET | /alumnos | alumnos.index | Listar alumnos |
| GET | /alumnos/create | alumnos.create | Formulario crear alumno |
| POST | /alumnos | alumnos.store | Guardar nuevo alumno |
| GET | /alumnos/{id} | alumnos.show | Ver detalles alumno |
| GET | /alumnos/{id}/edit | alumnos.edit | Formulario editar alumno |
| PUT | /alumnos/{id} | alumnos.update | Actualizar alumno |
| DELETE | /alumnos/{id} | alumnos.destroy | Eliminar alumno |
| GET | /lang/{locale} | lang.switch | Cambiar idioma |

## Campos del modelo Alumno

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | integer | Identificador único |
| nombre | string | Nombre del alumno |
| apellidos | string | Apellidos del alumno |
| email | string | Correo electrónico (único) |
| dni | string | DNI del alumno (único) |
| f_nac | date | Fecha de nacimiento |
| created_at | timestamp | Fecha de creación |
| updated_at | timestamp | Fecha de actualización |

## Tecnologías utilizadas

- **Laravel 11** - Framework PHP
- **Laravel Breeze** - Autenticación
- **TailwindCSS** - Framework CSS
- **DaisyUI** - Componentes UI
- **Font Awesome** - Iconos
- **Vite** - Build tool

## Autor

Diego Arruebo

## Licencia

Este proyecto es de código abierto bajo la licencia MIT.
