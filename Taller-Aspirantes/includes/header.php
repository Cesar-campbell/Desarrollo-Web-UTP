<?php
/**
 * includes/header.php
 * ------------------------------------------------------------------
 * Componente reutilizable que contiene:
 *   - El <head> con los metadatos y Bootstrap 5.3.8
 *   - El <header> con la barra de navegación (menú)
 *   - Las migas de pan (Breadcrumb) dinámicas
 * Se incluye con include desde index.php y procesar.php.
 * ------------------------------------------------------------------
 */

// Seguridad a nivel de componente (de script):
// Solo las páginas legítimas definen esta constante antes de hacer el include.
// Si alguien abre este archivo directo por la URL, la constante no existe y se bloquea.
if (!defined('INCLUDED_FROM_APP')) {
    http_response_code(403);
    die('Acceso denegado: No puedes ver este archivo directamente.');
}

// Detectamos el nombre del archivo actual (ej: index.php o procesar.php)
// basename() descarta las carpetas: "/Taller-Aspirantes/procesar.php" -> "procesar.php"
$paginaActual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Admisión de la UTP</title>
    <meta name="description" content="Sistema de admisión de datos para aspirantes">
    <meta name="author" content="Angel Gálvez - Universidad Tecnológica de Panamá / Estudiante">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#212529">

    <!-- Bootstrap v5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (iconos de redes sociales del footer) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <header>
        <!-- Navegación (menú) -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php">
                    <i class="bi bi-mortarboard-fill me-1"></i>PortalU
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
                        aria-controls="menuPrincipal" aria-expanded="false" aria-label="Mostrar menú">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($paginaActual == 'index.php') ? 'active' : ''; ?>"
                               href="index.php" <?php echo ($paginaActual == 'index.php') ? 'aria-current="page"' : ''; ?>>
                                Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#registro">Registro de aspirantes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Breadcrumb Dinámico (migas de pan) -->
        <div class="bg-white border-bottom py-2">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Inicio</a></li>

                        <?php if ($paginaActual == 'procesar.php'): ?>
                            <!-- Si estamos en el procesador, mostramos el paso intermedio y activamos el enlace para regresar -->
                            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Registro</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Procesando Datos</li>
                        <?php else: ?>
                            <!-- Si estamos en el inicio -->
                            <li class="breadcrumb-item active" aria-current="page">Registro de Aspirante</li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
