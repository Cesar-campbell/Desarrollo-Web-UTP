# Desarrollo Web UTP

Repositorio de prácticas y laboratorios del curso de Desarrollo Web, usando **PHP, HTML y CSS**.

## Estructura

```
Desarrollo-Web-UTP/
├── LAB_1_PHP/          Laboratorio 1: fundamentos de PHP
├── LAB_2_HTML5/        Laboratorio 2: HTML5 y CSS3
├── Taller-Aspirantes/  Laboratorio 3: registro de aspirantes
├── LAB_4_POO/          Laboratorio 4: programación orientada a objetos
├── LAB_5_LARAVEL/      Laboratorio 5: sistema de usuarios con Laravel y Breeze
├── practicas/          Ejercicios sueltos de PHP
└── extras/             Estilo Brave compartido por los laboratorios
```

## Laboratorios

### [LAB_1_PHP](LAB_1_PHP/) — Fundamentos de PHP
- [`Variable.php`](LAB_1_PHP/Variable.php) — Variables y salida dinámica con `echo`.
- [`Operaciones.php`](LAB_1_PHP/Operaciones.php) — Operaciones matemáticas básicas (suma, resta, multiplicación, división, módulo, potenciación, redondeo).
- [`Embebido.php`](LAB_1_PHP/Embebido.php) — Código PHP embebido dentro de HTML.
- [`Calculadora.php`](LAB_1_PHP/Calculadora.php) — Calculadora básica con formulario y redondeo de resultados.
- [`Circunferencia.php`](LAB_1_PHP/Circunferencia.php) — Área y perímetro de un círculo a partir del radio.
- [`Convertidor.php`](LAB_1_PHP/Convertidor.php) — Convertidor de pulgadas a centímetros.
- [`Formulario.php`](LAB_1_PHP/Formulario.php) — Formulario HTML que envía datos a `pagina2.php`.
- [`pagina2.php`](LAB_1_PHP/pagina2.php) — Procesa el formulario (nombre y edad) y valida mayoría de edad.
- [`info.php`](LAB_1_PHP/info.php) — Información de configuración de PHP (`phpinfo()`).
- [`Equipos.php`](LAB_1_PHP/Equipos.php) — Recorrido de un array asociativo (equipo de fútbol) con `foreach`.
- [`Random.php`](LAB_1_PHP/Random.php) — Generador de números aleatorios con `do...while`.

### [LAB_2_HTML5](LAB_2_HTML5/) — HTML5 y CSS3
- Párrafos: [`parrafos.html`](LAB_2_HTML5/parrafos.html) con [`estilosParrafos.css`](LAB_2_HTML5/estilosParrafos.css).
- Tablas: [`tablas.html`](LAB_2_HTML5/tablas.html), [`tablas2.html`](LAB_2_HTML5/tablas2.html) y [`Tablas.html`](LAB_2_HTML5/Tablas.html) con [`estilosTabla.css`](LAB_2_HTML5/estilosTabla.css).
- Ejemplos: [`Ejemplo1.html`](LAB_2_HTML5/Ejemplo1.html) y [`EjemploSecciones.php`](LAB_2_HTML5/EjemploSecciones.php).

### [Taller-Aspirantes](Taller-Aspirantes/) — Registro de Aspirantes
Sistema en PHP y Bootstrap para registrar aspirantes: formulario con datos personales y fotografía, validación y saneamiento en el backend, y almacenamiento de la foto en una carpeta protegida. No usa base de datos. Ver su [README](Taller-Aspirantes/README.md).

### [LAB_4_POO](LAB_4_POO/) — Programación orientada a objetos
- [`Problema_1_Herencia.php`](LAB_4_POO/Problema_1_Herencia.php) a [`Problema_5_Herencia.php`](LAB_4_POO/Problema_5_Herencia.php) — Cinco problemas de herencia en PHP.

### [LAB_5_LARAVEL](LAB_5_LARAVEL/) — Sistema de usuarios con Laravel
Aplicación en Laravel 13 con Breeze y SQLite: registro, inicio de sesión, modificación del perfil y eliminación de la cuenta. Su [README](LAB_5_LARAVEL/README.md) documenta con capturas cada operación (insertar, modificar, eliminar), los controles usados, la instalación paso a paso y las versiones.

## Prácticas — [practicas/](practicas/)
- [`For.php`](practicas/For.php) — Bucle `for`.
- [`Foreach.php`](practicas/Foreach.php) — Bucle `foreach` sobre un array de animales.
- [`EjemploLateStatic.php`](practicas/EjemploLateStatic.php) — Ejemplo de enlace estático tardío (`static::`).
- [`IA.php`](practicas/IA.php) — Chat con IA básica usando `$_SESSION` para mantener el historial.

## Extras — [extras/](extras/)
- [`Brave.html`](extras/Brave.html) y [`brave-style.css`](extras/brave-style.css) — Página de ejemplo y hoja de estilos inspirada en Brave Browser. Los laboratorios 1 y 2 enlazan este CSS con `../extras/brave-style.css`.

---
Curso: Desarrollo Web — UTP
