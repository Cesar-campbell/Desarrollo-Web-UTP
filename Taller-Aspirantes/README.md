# Taller-Aspirantes: Registro de Aspirantes (Laboratorio #3)

Sistema web en PHP y Bootstrap 5.3.8 para registrar aspirantes. El formulario recibe los datos personales y una fotografía. El backend valida, sanea y estandariza la información, y guarda la foto en una carpeta protegida del servidor. No se usa base de datos.

| | |
|---|---|
| **Estudiante** | Angel Gálvez |
| **Docente** | Ing. Irina Fong |
| **Institución** | Universidad Tecnológica de Panamá, Facultad de Ingeniería de Sistemas Computacionales |
| **Asignatura / Grupo** | _(completar)_ |
| **Fecha de entrega** | 02 de octubre de 2026 |

## Tecnologías

- HTML5 con etiquetas semánticas (`<header>`, `<main>`, `<section>`, `<footer>`)
- Bootstrap v5.3.8 y Bootstrap Icons, cargados por CDN
- PHP 8 (`include`, `basename`, `$_SERVER`, `$_POST`, `$_FILES`)
- Apache (WampServer) con `.htaccess`

## Estructura del proyecto

```
Taller-Aspirantes/
├── includes/
│   ├── .htaccess        Bloquea el acceso directo por URL a los componentes
│   ├── header.php       <head> con metadatos, <header>, Navbar y Breadcrumb dinámico
│   ├── footer.php       <footer> con enlaces, redes, eslogan y año dinámico
│   └── formulario.php   Formulario de registro (se incluye en index.php)
├── uploaded_files/
│   ├── .htaccess        Bloquea el acceso desde el navegador a las fotos
│   └── .gitkeep         Mantiene la carpeta vacía en Git
├── .gitignore           Evita subir las fotos de los aspirantes al repositorio
├── index.php            Página principal con el formulario visual de registro
├── procesar.php         Backend que valida, procesa y muestra el resultado
└── README.md
```

## Requisitos

- WampServer (Apache 2.4 y PHP 8.x) o un entorno equivalente (XAMPP, Laragon)
- `AllowOverride All` habilitado en Apache para que funcionen los `.htaccess` (viene así por defecto en WampServer)
- Conexión a internet para cargar Bootstrap desde el CDN

## Instalación y ejecución

1. Copiar la carpeta `Taller-Aspirantes` dentro de `C:\wamp64\www\`.
2. Iniciar WampServer y esperar a que el ícono quede en verde.
3. Abrir en el navegador: `http://localhost/Taller-Aspirantes/`

## Funcionamiento

**index.php** define la constante `INCLUDED_FROM_APP` y arma la página con tres `include`: la navegación (`header.php`), el formulario (`formulario.php`, dentro de `<main><section>`) y el pie de página (`footer.php`).

**El formulario** envía los datos por `POST` con `enctype="multipart/form-data"`. Todos los campos son requeridos y usan `placeholder` para indicar el dato esperado:

- Nombre, Apellido e Identificación (`type="text"`)
- Fecha de nacimiento (`type="date"`)
- Sexo (radio buttons Hombre / Mujer)
- Fotografía (`type="file"`)

**procesar.php** realiza, en orden:

1. Rechaza el acceso por GET y redirige a `index.php`.
2. Sanea las entradas con `trim()` y `strip_tags()`.
3. Valida que ningún campo esté vacío.
4. Estandariza el nombre y el apellido a formato tipo título con `ucwords(strtolower())`. Por ejemplo, "sofia" pasa a "Sofia" y "ángel" pasa a "Ángel".
5. Convierte la identificación a mayúsculas con `strtoupper()`.
6. Calcula la edad a partir de la fecha de nacimiento y verifica que esté entre **18 y 70 años**.
7. Valida la fotografía:
   - extensión permitida (jpg, jpeg, png, gif, webp)
   - tamaño máximo de 2 MB
   - contenido real de imagen con `getimagesize()`
8. Guarda la foto en `uploaded_files/` con un nombre aleatorio usando `move_uploaded_file()`.
9. Muestra el resultado escapado con `htmlspecialchars()` para prevenir XSS.

**El breadcrumb** cambia según la página actual, detectada con `basename($_SERVER['PHP_SELF'])`:
- En `index.php` muestra: Inicio / Registro de Aspirante
- En `procesar.php` muestra: Inicio / Registro / Procesando Datos

**El footer** incluye derechos de autor con el año dinámico (`echo date('Y');`), redes sociales y contacto, enlaces rápidos y el eslogan institucional.

## Seguridad aplicada

| Nivel | Técnica | Qué protege |
|---|---|---|
| Perimetral (carpeta) | `.htaccess` con `Require all denied` | `includes/` y `uploaded_files/` no se pueden abrir desde el navegador (403 Forbidden) |
| Componente (script) | `if (!defined('INCLUDED_FROM_APP')) die(...)` | Los archivos de `includes/` no se ejecutan solos, aunque falle el `.htaccess` |
| Entrada | `trim()`, `strip_tags()`, expresiones regulares, lista blanca de sexo | Datos limpios y con formato válido |
| Salida | `htmlspecialchars()` | Previene ataques XSS |
| Archivos | Extensión, tamaño, `getimagesize()`, nombre aleatorio, `chmod 0644` | Evita subir scripts disfrazados de imagen y sobrescribir archivos |

Como `uploaded_files/` está bloqueada para el navegador, `procesar.php` lee la foto desde el disco y la muestra incrustada en Base64 en la página de resultado.

## Pruebas realizadas

| Caso | Resultado esperado |
|---|---|
| Datos válidos con espacios extra y minúsculas | Registro exitoso con el nombre en formato título |
| Edad menor de 18 o mayor de 70 | Mensaje de error con la edad calculada |
| Campos vacíos o sin foto | Lista de errores por campo |
| Archivo `.pdf` o un `.php` renombrado a `.jpg` | Archivo rechazado |
| Foto mayor de 2 MB | Archivo rechazado por tamaño |
| Abrir `includes/header.php` o `uploaded_files/` en el navegador | 403 Forbidden |
| Abrir `procesar.php` directamente | Redirección a `index.php` |
