# LAB_5_LARAVEL — Usuarios y CRUD de productos con Laravel

Aplicación web en **Laravel 13** con autenticación (registro, inicio de sesión) y gestión de la cuenta del usuario, hecha con el starter kit **Laravel Breeze** (Blade + Tailwind CSS) sobre una base de datos **SQLite**.

El laboratorio cubre las tres operaciones sobre la tabla `users`:

| Operación | Dónde se hace en la app | Ruta |
|---|---|---|
| **Insertar** | Formulario de registro | `/register` |
| **Modificar** | Perfil → Profile Information | `/profile` |
| **Eliminar** | Perfil → Delete Account | `/profile` |

Además incluye un **CRUD completo de la tabla `products`** (crear, listar, ver, editar y eliminar), generado con `ibex/crud-generator` y protegido por inicio de sesión. Ver la [sección 4](#4-crud-de-productos).

---

## 1. Insertar registros

El registro de un usuario nuevo se hace desde `/register` con nombre, correo y contraseña.

**Formulario de registro vacío**

![Formulario de registro vacío](assets/01-registro-vacio.png)

**Validación:** si la contraseña y su confirmación no coinciden, Laravel rechaza el registro y no guarda nada.

![Error de validación en el registro](assets/02-registro-error-validacion.png)

**Formulario con datos válidos**

![Formulario de registro lleno](assets/03-registro-lleno.png)

**Registro exitoso:** el usuario se guarda en la tabla `users` (con la contraseña cifrada), inicia sesión automáticamente y llega al Dashboard.

![Registro exitoso: Dashboard](assets/04-registro-exitoso-dashboard.png)

---

## 2. Evidencia de acciones de Modificar

Con la sesión iniciada, la página `/profile` permite cambiar el nombre y el correo.

**Perfil con los datos originales**

![Perfil del usuario](assets/05-perfil.png)

**Datos modificados** (nombre: `Cesar A. Campbell`, correo: `cesar.campbell.mod@utp.ac.pa`)

![Formulario de perfil modificado](assets/06-modificar-formulario.png)

**Cambios guardados:** aparece el mensaje *Saved.* y el nuevo nombre se refleja en la barra superior.

![Modificación guardada](assets/07-modificar-guardado.png)

---

## 3. Evidencia de acciones de Eliminar

El botón **Delete Account** abre una ventana modal que pide la contraseña para confirmar.

**Confirmación de la eliminación**

![Confirmación para eliminar la cuenta](assets/08-eliminar-confirmacion.png)

**Cuenta eliminada:** el registro se borra de `users`, la sesión se cierra y la app vuelve a la página de inicio.

![Resultado de eliminar la cuenta](assets/09-eliminar-resultado.png)

**Comprobación:** al intentar iniciar sesión con el usuario eliminado, Laravel responde que las credenciales no coinciden.

![Login con el usuario eliminado](assets/10-login-usuario-eliminado.png)

---

## 4. CRUD de productos

Con la sesión iniciada, la ruta `/products` permite administrar la tabla `products`, que tiene tres campos: **descripción**, **precio** y **stock**. Si se entra sin sesión, Laravel redirige a `/login`.

| Operación | Acción en la app | Método y ruta | Método del controlador |
|---|---|---|---|
| **Listar** | Página principal de productos | GET `/products` | `index` |
| **Crear** | Botón *Add new* → formulario | GET `/products/create`, POST `/products` | `create`, `store` |
| **Ver** | Enlace *Show* | GET `/products/{id}` | `show` |
| **Editar** | Enlace *Edit* → formulario | GET `/products/{id}/edit`, PATCH `/products/{id}` | `edit`, `update` |
| **Eliminar** | Enlace *Delete* (pide confirmación) | DELETE `/products/{id}` | `destroy` |

### Listar
Al inicio la tabla está vacía.

![Lista de productos vacía](assets/11-productos-lista-vacia.png)

### Crear
**Formulario de nuevo producto**

![Formulario para crear producto](assets/12-producto-crear-formulario.png)

**Validación:** `ProductRequest` exige los tres campos; si se envía vacío, Laravel muestra el error bajo cada uno y no guarda nada.

![Error de validación al crear producto](assets/13-producto-error-validacion.png)

**Formulario con datos válidos**

![Formulario de producto lleno](assets/14-producto-crear-lleno.png)

**Productos guardados:** después de registrar tres productos, la lista los muestra con sus acciones *Show*, *Edit* y *Delete*.

![Lista con tres productos](assets/15-productos-lista.png)

### Ver detalle

![Detalle del producto](assets/16-producto-detalle.png)

### Editar
Se cambia el precio de la laptop de `549.99` a `499.99` y el stock de `12` a `10`.

![Formulario de edición](assets/17-producto-editar.png)

**Cambios guardados:** la lista ya muestra los valores nuevos.

![Producto actualizado](assets/18-producto-actualizado.png)

### Eliminar
Al pulsar *Delete* el navegador pide confirmar (*Are you sure to delete?*). Al aceptar, el registro se borra de la tabla; aquí se eliminó el mouse.

![Producto eliminado](assets/19-producto-eliminado.png)

### Archivos del CRUD (MVC)

| Capa | Archivo | Qué hace |
|---|---|---|
| Migración | `database/migrations/2026_10_16_132956_create_products_table.php` | Crea la tabla `products` (`id`, `description`, `price`, `stock`, fechas) |
| Modelo | `app/Models/Product.php` | Modelo Eloquent; `$fillable` permite guardar `description`, `price` y `stock` |
| Validación | `app/Http/Requests/ProductRequest.php` | Reglas: los tres campos son obligatorios |
| Controlador | `app/Http/Controllers/ProductController.php` | Los 7 métodos del recurso (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) |
| Vistas | `resources/views/product/` | `index`, `create`, `edit`, `show` y el formulario compartido `form` |
| Rutas | `routes/web.php` | `Route::resource('products', ProductController::class)` dentro del grupo `auth` |

### Comandos utilizados

```bash
composer require ibex/crud-generator --dev      # paquete generador del CRUD
php artisan vendor:publish --tag=crud           # publica config/crud.php
php artisan make:migration create_products_table
php artisan migrate                             # crea la tabla products
php artisan make:crud products                  # genera modelo, controlador, request y vistas
npm run build                                   # recompila Tailwind con las clases de las vistas nuevas
```

Después se agregó la ruta `Route::resource('products', ProductController::class);` en `routes/web.php`.

---

## 5. Controles utilizados

| Control / elemento | Uso en el laboratorio |
|---|---|
| Campo de texto (`type="text"`) | Nombre del usuario |
| Campo de correo (`type="email"`) | Correo del usuario (único, se usa para iniciar sesión) |
| Campo de contraseña (`type="password"`) | Contraseña, confirmación y contraseña actual |
| Casilla (`type="checkbox"`) | *Remember me* en el login |
| Botones (`submit`) | Register, Log in, Save, Delete Account |
| Ventana modal (Alpine.js) | Confirmación para eliminar la cuenta |
| Mensajes de validación | Errores bajo cada campo (`x-input-error`) y estado *Saved.* |
| Token CSRF (`@csrf`) | Protege cada formulario contra peticiones falsas |
| Método simulado (`@method('patch')`, `@method('delete')`) | Permite enviar PATCH y DELETE desde formularios HTML |
| Componentes Blade (`x-text-input`, `x-input-label`, `x-primary-button`, `x-danger-button`, `x-modal`) | Piezas reutilizables en `resources/views/components` |
| Middleware `auth` | Solo los usuarios con sesión entran a `/dashboard`, `/profile` y `/products` |
| Tabla con paginación | Lista de productos (`Product::paginate()`, 20 por página) |
| Diálogo `confirm()` de JavaScript | Confirmación antes de eliminar un producto |

---

## 6. Detalles del laboratorio

### Objetivo
Construir un sistema de registro e inicio de sesión en Laravel siguiendo el patrón MVC, y comprobar las operaciones de insertar, modificar y eliminar sobre la tabla de usuarios. Como segunda parte, crear un CRUD completo para la tabla de productos.

### Arquitectura MVC

| Capa | Carpeta / archivo | Contenido |
|---|---|---|
| Modelo | `app/Models/User.php`, `app/Models/Product.php` | Modelos Eloquent de las tablas `users` y `products` |
| Vista | `resources/views/` | Plantillas Blade: `auth/` (login, registro), `profile/`, `dashboard.blade.php`, `components/`, `layouts/`, `product/` |
| Controlador | `app/Http/Controllers/` | `ProfileController` (editar, actualizar, eliminar) y `Auth/` (registro, login, logout, contraseñas) y `ProductController` (CRUD de productos) |
| Rutas | `routes/web.php` y `routes/auth.php` | Asocian cada URL con su controlador |

### Rutas principales

| Método | Ruta | Acción |
|---|---|---|
| GET / POST | `/register` | Mostrar formulario / **insertar** usuario |
| GET / POST | `/login` | Mostrar formulario / iniciar sesión |
| GET | `/dashboard` | Panel (requiere sesión) |
| GET | `/profile` | Ver el perfil |
| PATCH | `/profile` | **Modificar** nombre y correo |
| DELETE | `/profile` | **Eliminar** la cuenta |
| GET, POST, PATCH, DELETE | `/products...` | CRUD de productos (ver [sección 4](#4-crud-de-productos)) |

### Base de datos
SQLite en `database/database.sqlite`. Las migraciones crean las tablas `users`, `products`, `password_reset_tokens`, `sessions`, `cache` y `jobs`, entre otras. Las contraseñas se guardan con hash.

### Estructura del proyecto

```
LAB_5_LARAVEL/
├── app/                  Modelos y controladores
├── assets/               Capturas de este README
├── bootstrap/
├── config/
├── database/             Migraciones, seeders y factories
├── public/               Punto de entrada (index.php)
├── resources/            Vistas Blade, CSS y JS
├── routes/               web.php y auth.php
├── storage/
├── tests/                Pruebas automáticas
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

### Verificación
Se comprobó una instalación desde cero (pasos de la sección 7) en una copia limpia de la carpeta: `/`, `/login` y `/register` responden **200** y las **25 pruebas** de `php artisan test` pasan. Las capturas se tomaron con la app corriendo sobre una base de datos de prueba.

---

## 7. Procesos de instalación

### Requisitos previos

| Requisito | Versión |
|---|---|
| PHP | 8.3 o superior (probado con 8.5.11) |
| Composer | 2.x (probado con 2.10.3) |
| Node.js y NPM | Node 22 y NPM 10 |
| Extensión PHP SQLite | `pdo_sqlite` |

En Fedora, el paquete de Node se llama `nodejs`: `sudo dnf install nodejs`.

### Pasos

1. **Clonar el repositorio y entrar a la carpeta**
   ```bash
   git clone https://github.com/Cesar-campbell/Desarrollo-Web-UTP.git
   cd Desarrollo-Web-UTP/LAB_5_LARAVEL
   ```
2. **Instalar las dependencias**
   ```bash
   composer install
   npm install
   ```
3. **Crear el archivo de entorno y la clave de la aplicación**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   El `.env.example` ya usa `DB_CONNECTION=sqlite`, así que no hay que configurar usuario ni contraseña de base de datos.
4. **Crear la base de datos y las tablas**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```
5. **Compilar los estilos y scripts**
   ```bash
   npm run build
   ```
6. **Iniciar el servidor**
   ```bash
   php artisan serve
   ```
7. Abrir en el navegador: <http://127.0.0.1:8000>. Usar `/register` para crear un usuario y `/login` para entrar.

Para desarrollar con recarga automática de estilos, ejecutar `npm run dev` en una segunda terminal.

### Cómo se creó el proyecto

```bash
composer create-project laravel/laravel Lab_laravel
cd Lab_laravel
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
php artisan migrate
```

Los comandos del CRUD de productos están en la [sección 4](#comandos-utilizados).

### Dificultades y soluciones

| Problema | Solución |
|---|---|
| `dnf install node.js` no encuentra el paquete | El paquete se llama `nodejs`, sin punto |
| Vite muestra `Cannot find module 'autoprefixer'` | El servidor `npm run dev` se inició antes de terminar `npm install`. Detenerlo con `Ctrl+C`, ejecutar de nuevo `npm run dev` y recargar con `Ctrl+Shift+R` |
| La página sale sin estilos | Falta compilar los assets: ejecutar `npm run build` |

---

## 8. Tecnologías y versiones

| Tecnología | Versión |
|---|---|
| PHP | 8.5.11 (requiere ^8.3) |
| Laravel Framework | 13.35.0 |
| Laravel Breeze | ^2.4 |
| ibex/crud-generator | ^2.1 |
| Base de datos | SQLite |
| Composer | 2.10.3 |
| Node.js / NPM | 22.23.1 / 10.9.8 |
| Vite | ^8.0 |
| Tailwind CSS | ^3.1 |
| Alpine.js | ^3.4 |
| DBeaver | Cliente usado para revisar la tabla `users` |
| Sistema operativo | Linux (Nobara / Fedora) |

---

## 9. Autor, fecha y referencias

| | |
|---|---|
| **Autor** | Cesar Campbell |
| **Aula** | 1S3122 |
| **Curso** | Desarrollo Web |
| **Docente** | Ing. Irina Fong |
| **Institución** | Universidad Tecnológica de Panamá (UTP) |
| **Fecha de ejecución** | 13 de octubre de 2026 (login) y 16 de octubre de 2026 (CRUD de productos) |

### Referencias
- [Documentación de Laravel](https://laravel.com/docs)
- [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
- [Migraciones de Laravel](https://laravel.com/docs/migrations)
- [Composer](https://getcomposer.org/doc/)
- [Vite](https://vite.dev/) y [Tailwind CSS](https://tailwindcss.com/docs)
- [ibex/crud-generator](https://github.com/awais-vteams/laravel-crud-generator)
- [Controladores de recurso](https://laravel.com/docs/controllers#resource-controllers)
- [Proyecto de referencia: LaravelLaboratorio2](https://github.com/AntonioCastillo507/LaravelLaboratorio2)
