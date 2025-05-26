# 🐾 TFG Veterinario

Este proyecto es parte del Trabajo de Fin de Grado (TFG) para el ciclo de Desarrollo de Aplicaciones Web.  
Actualmente cuenta con autenticación, roles, sistema de recuperación de contraseña y una landing page funcional con diseño responsive.

---

## Funcionalidades incluidas

- Registro de usuarios con campos: `dni`, `nombre`, `email`, `password`
- Validación de campos (`dni` y `email` únicos, `password` confirmada)
- Login de usuario con redirección automática según su rol:
  - `cliente` → `/dashboard_cliente`
  - `trabajador` → `/dashboard_trabajador`
  - `admin` → `/dashboard_admin`
- Middleware personalizados que restringen acceso a rutas por rol
- Layouts y navegación adaptados dinámicamente al tipo de usuario
- Protección de rutas para evitar accesos cruzados entre roles
- Separación de ramas Git:
  - `main` → rama limpia con avances estables
  - `dev` → rama de desarrollo activo

---

### 🔐 Autenticación avanzada y recuperación

- Envío real de correos con Gmail usando contraseña de aplicación
- Recuperación de contraseña por email con enlace de restablecimiento
- Correo HTML personalizado con branding (logo, colores, botón)
- Formularios estilizados con Tailwind CSS
- Validación completa en login, registro y recuperación
- Redirección automática tras login según rol
- Protección contra accesos indebidos a `/login` y `/register` si ya hay sesión activa
- Rediseño responsive con favicon y logo integrados

---

## Requisitos

- PHP 8.1 o superior
- Composer
- MySQL / MariaDB
- Node.js + NPM (opcional, si se usan assets con Vite)
- Laravel 12.x

---

## Instalación del proyecto (en otro equipo)

### 1. Clonar el repositorio

```bash
git clone https://github.com/sergiogr04/veterinario.git
cd veterinario
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Crear el archivo `.env`

```bash
cp .env.example .env
```

Y configurar tus credenciales de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veterinario
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 5. Crear la base de datos

- En MySQL, crear una base de datos llamada `veterinario`
- Importar el archivo `db.sql` si está incluido

### 6. Ejecutar migraciones (si no importas un .sql)

```bash
php artisan migrate
```

### 6.1. Configurar el envío de correos

Si quieres usar Gmail para enviar correos de recuperación de contraseña:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=contraseña_de_aplicación
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu_email@gmail.com
MAIL_FROM_NAME="Clínica San Lorenzo"
```

Activa la verificación en 2 pasos en Gmail y genera una contraseña de aplicación aquí:  
[https://myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)

### 7. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

Y accede desde el navegador a `http://127.0.0.1:8000`

---

## Rutas protegidas por rol

| Rol         | Ruta Acceso            | Middleware aplicado |
|-------------|------------------------|----------------------|
| Cliente     | `/dashboard_cliente`   | `auth`, `isCliente`  |
| Trabajador  | `/dashboard_trabajador`| `auth`, `isTrabajador` |
| Admin       | `/dashboard_admin`     | `auth`, `isAdmin`    |

---

## Estructura relevante del proyecto

```
app/
├── Http/
│   ├── Middleware/
│   │   ├── IsCliente.php
│   │   ├── IsAdmin.php
│   │   └── IsTrabajador.php
│   └── Kernel.php
routes/
└── web.php
resources/
└── views/
    ├── dashboards/
    │   ├── cliente.blade.php
    │   ├── trabajador.blade.php
    │   └── admin.blade.php
    ├── auth/
    │   ├── login.blade.php
    │   ├── register.blade.php
    │   ├── forgot-password.blade.php
    │   └── reset-password.blade.php
```

---

## Usuarios de prueba recomendados (crear manualmente)

| Rol         | Email                 | Contraseña | Notas                         |
|-------------|-----------------------|------------|-------------------------------|
| Cliente     | cliente@example.com   | 12345678   | Añadir desde formulario o SQL |
| Trabajador  | trabajador@example.com| 12345678   | Editar en la BD su `rol`      |
| Admin       | admin@example.com     | 12345678   | Editar en la BD su `rol`      |

---

## Autor

**Sergio Gómez Rosa**  
Proyecto de TFG para el ciclo DAW (Desarrollo de Aplicaciones Web)