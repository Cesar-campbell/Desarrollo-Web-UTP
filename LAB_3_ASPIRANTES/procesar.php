<?php
/**
 * procesar.php
 * ------------------------------------------------------------------
 * Backend que valida, procesa y muestra el resultado del registro.
 *   1. Valida que los campos no estén vacíos.
 *   2. Sanea y estandariza los textos (trim, strip_tags, htmlspecialchars,
 *      ucwords(strtolower()) y strtoupper()).
 *   3. Calcula la edad y verifica que esté entre 18 y 70 años.
 *   4. Valida la imagen (jpg, jpeg, png, gif, webp).
 *   5. Guarda la foto de forma segura en ./uploaded_files/ (sin base de datos).
 * ------------------------------------------------------------------
 */

// Permiso para que los archivos de includes/ se puedan ejecutar
define('INCLUDED_FROM_APP', true);

// Si alguien entra a procesar.php escribiendo la URL (GET), lo regresamos al formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

/* ===================== CONFIGURACIÓN ===================== */
const EDAD_MINIMA            = 18;
const EDAD_MAXIMA            = 70;
const TAMANO_MAXIMO          = 2 * 1024 * 1024;                       // 2 MB
const EXTENSIONES_PERMITIDAS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
const TIPOS_MIME_PERMITIDOS  = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
const SEXOS_PERMITIDOS       = ['Hombre', 'Mujer'];

// Ruta física de la carpeta de fotos (dirname(__FILE__) es lo mismo que __DIR__)
$carpetaFotos = __DIR__ . '/uploaded_files/';

/* ===================== FUNCIONES ===================== */

/**
 * Saneamiento: obtiene un campo de $_POST como texto plano.
 * trim()       -> quita espacios, tabulaciones y saltos al inicio y al final.
 * strip_tags() -> elimina etiquetas HTML/PHP (ej: "<b>Ana</b>" -> "Ana").
 */
function limpiarTexto(string $campo): string
{
    $valor = $_POST[$campo] ?? '';
    if (!is_string($valor)) {          // Evita que envíen un arreglo (nombre[]=...)
        return '';
    }
    $valor = trim(strip_tags($valor));
    return preg_replace('/\s+/u', ' ', $valor) ?? '';   // Deja un solo espacio entre palabras
}

/**
 * Normalización a Formato Tipo Título: "sofia" -> "Sofia", "MARÍA JOSÉ" -> "María José".
 * Se aplica ucwords(strtolower()) como pide el laboratorio; luego mb_convert_case()
 * corrige las palabras que empiezan con tilde o ñ (ej: "ángel" -> "Ángel"),
 * porque strtolower()/ucwords() solo trabajan con letras sin acento.
 */
function formatoTitulo(string $texto): string
{
    $texto = ucwords(strtolower($texto));
    if (function_exists('mb_convert_case')) {
        $texto = mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
    }
    return $texto;
}

/**
 * Seguridad en la salida: htmlspecialchars() convierte < > & ' " en entidades HTML
 * para prevenir ataques XSS al mostrar datos del usuario en la página.
 */
function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

/* ===================== PROCESAMIENTO ===================== */
$errores = [];

// Si el envío supera post_max_size (php.ini), PHP deja $_POST y $_FILES vacíos
if (empty($_POST) && empty($_FILES) && !empty($_SERVER['CONTENT_LENGTH'])) {
    $errores[] = 'El envío es demasiado grande. La fotografía no puede superar los 2 MB.';
}

// 1) Recibir y sanear
$nombre         = limpiarTexto('nombre');
$apellido       = limpiarTexto('apellido');
$identificacion = strtoupper(limpiarTexto('identificacion'));   // Mayúsculas cerradas
$fechaTexto     = limpiarTexto('fecha_nacimiento');
$sexo           = limpiarTexto('sexo');

// 2) Validar que los campos no estén vacíos
if ($nombre === '')         { $errores[] = 'El nombre es obligatorio.'; }
if ($apellido === '')       { $errores[] = 'El apellido es obligatorio.'; }
if ($identificacion === '') { $errores[] = 'La identificación es obligatoria.'; }
if ($fechaTexto === '')     { $errores[] = 'La fecha de nacimiento es obligatoria.'; }
if ($sexo === '')           { $errores[] = 'Debes seleccionar el sexo.'; }

// 3) Validar formato de nombre y apellido (solo letras, espacios, guion y apóstrofo)
if ($nombre !== '' && !preg_match("/^[\p{L}' -]{2,50}$/u", $nombre)) {
    $errores[] = 'El nombre solo puede contener letras y espacios (2 a 50 caracteres).';
}
if ($apellido !== '' && !preg_match("/^[\p{L}' -]{2,50}$/u", $apellido)) {
    $errores[] = 'El apellido solo puede contener letras y espacios (2 a 50 caracteres).';
}

// Estandarizar a Formato Tipo Título (Nombre y Apellido)
$nombre   = formatoTitulo($nombre);
$apellido = formatoTitulo($apellido);

// 4) Validar identificación (letras, números y guiones; ej: 8-123-4567, PE-1-234, E-8-12345)
if ($identificacion !== '' && !preg_match('/^[A-Z0-9]+(-[A-Z0-9]+)*$/', $identificacion)) {
    $errores[] = 'La identificación solo puede contener letras, números y guiones (ej: 8-123-4567).';
} elseif ($identificacion !== '' && (strlen($identificacion) < 5 || strlen($identificacion) > 20)) {
    $errores[] = 'La identificación debe tener entre 5 y 20 caracteres.';
}

// 5) Validar sexo contra una lista blanca
if ($sexo !== '' && !in_array($sexo, SEXOS_PERMITIDOS, true)) {
    $errores[] = 'El valor de sexo no es válido.';
}

// 6) Calcular la edad y verificar el rango de 18 a 70 años
$edad = null;
$fechaNacimiento = null;
if ($fechaTexto !== '') {
    $fechaNacimiento = DateTime::createFromFormat('!Y-m-d', $fechaTexto);

    if ($fechaNacimiento === false || $fechaNacimiento->format('Y-m-d') !== $fechaTexto) {
        $errores[] = 'La fecha de nacimiento no es válida.';
        $fechaNacimiento = null;
    } else {
        $hoy = new DateTime('today');
        if ($fechaNacimiento > $hoy) {
            $errores[] = 'La fecha de nacimiento no puede ser una fecha futura.';
        } else {
            $edad = $fechaNacimiento->diff($hoy)->y;   // Años cumplidos
            if ($edad < EDAD_MINIMA || $edad > EDAD_MAXIMA) {
                $errores[] = 'La edad del aspirante es de ' . $edad . ' años. Debe estar entre '
                           . EDAD_MINIMA . ' y ' . EDAD_MAXIMA . ' años.';
            }
        }
    }
}

// 7) Validar la fotografía
$foto = $_FILES['foto'] ?? null;
$extension = '';

if (!is_array($foto) || !isset($foto['error']) || is_array($foto['error'])) {
    $errores[] = 'La fotografía del aspirante es obligatoria.';
} elseif ($foto['error'] !== UPLOAD_ERR_OK) {
    switch ($foto['error']) {
        case UPLOAD_ERR_NO_FILE:
            $errores[] = 'La fotografía del aspirante es obligatoria.';
            break;
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $errores[] = 'La fotografía supera el tamaño máximo permitido (2 MB).';
            break;
        case UPLOAD_ERR_PARTIAL:
            $errores[] = 'La fotografía se subió de forma incompleta. Inténtalo de nuevo.';
            break;
        default:
            $errores[] = 'Ocurrió un error en el servidor al subir la fotografía.';
    }
} else {
    // Extensión: se toma la última parte del nombre y se pasa a minúsculas ("FOTO.JPG" -> "jpg")
    $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, EXTENSIONES_PERMITIDAS, true)) {
        $errores[] = 'Formato no permitido. Solo se aceptan: ' . implode(', ', EXTENSIONES_PERMITIDAS) . '.';
    } elseif ($foto['size'] > TAMANO_MAXIMO) {
        $errores[] = 'La fotografía supera el tamaño máximo permitido (2 MB).';
    } elseif (!is_uploaded_file($foto['tmp_name'])) {
        $errores[] = 'El archivo recibido no es válido.';
    } else {
        // No basta con la extensión: se revisa el CONTENIDO real del archivo.
        // Así un "virus.php" renombrado a "virus.jpg" es rechazado.
        $infoImagen = @getimagesize($foto['tmp_name']);
        $tipoMime   = $infoImagen['mime'] ?? '';

        if ($infoImagen === false || !in_array($tipoMime, TIPOS_MIME_PERMITIDOS, true)) {
            $errores[] = 'El archivo seleccionado no es una imagen válida.';
        }
    }
}

// 8) Guardar la foto SOLO si todo lo demás es válido
$nombreArchivo = '';
$fotoParaMostrar = '';

if (empty($errores)) {
    // Crea la carpeta si no existe
    if (!is_dir($carpetaFotos) && !mkdir($carpetaFotos, 0755, true)) {
        $errores[] = 'No se pudo crear la carpeta de fotografías en el servidor.';
    } elseif (!is_writable($carpetaFotos)) {
        $errores[] = 'La carpeta uploaded_files/ no tiene permisos de escritura.';
    } else {
        // Nombre nuevo, aleatorio e impredecible (nunca se usa el nombre original del usuario)
        $nombreArchivo = 'aspirante_' . date('Ymd_His') . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
        $rutaDestino   = $carpetaFotos . $nombreArchivo;

        if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
            chmod($rutaDestino, 0644);   // Solo lectura/escritura para el dueño; nada de ejecución

            // La carpeta está bloqueada para el navegador (.htaccess), así que PHP lee la
            // imagen desde el disco y la muestra incrustada (Base64) en la página de resultado.
            $fotoParaMostrar = 'data:' . $tipoMime . ';base64,' . base64_encode(file_get_contents($rutaDestino));
        } else {
            $errores[] = 'No se pudo guardar la fotografía. Inténtalo de nuevo.';
        }
    }
}

/* ===================== VISTA ===================== */
// Navegación (el breadcrumb mostrará: Inicio / Registro / Procesando Datos)
include __DIR__ . '/includes/header.php';
?>

    <main class="flex-grow-1 d-flex align-items-center py-5">
        <div class="container">
            <section class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6">

                <?php if (!empty($errores)): ?>
                    <!-- Resultado con errores -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h1 class="h4 text-danger mb-3">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>No se pudo registrar al aspirante
                            </h1>
                            <div class="alert alert-danger mb-4" role="alert">
                                <p class="fw-semibold mb-2">Corrige lo siguiente:</p>
                                <ul class="mb-0">
                                    <?php foreach ($errores as $error): ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <a href="index.php" class="btn btn-primary w-100">Volver al formulario</a>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Resultado exitoso -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="alert alert-success" role="alert">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                Aspirante registrado correctamente.
                            </div>

                            <div class="text-center mb-4">
                                <img src="<?php echo e($fotoParaMostrar); ?>"
                                     alt="Fotografía de <?php echo e($nombre . ' ' . $apellido); ?>"
                                     class="rounded border shadow-sm" style="width: 160px; height: 160px; object-fit: cover;">
                                <h1 class="h4 mt-3 mb-0"><?php echo e($nombre . ' ' . $apellido); ?></h1>
                            </div>

                            <table class="table table-sm mb-4">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="w-50">Nombre</th>
                                        <td><?php echo e($nombre); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Apellido</th>
                                        <td><?php echo e($apellido); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Identificación</th>
                                        <td><?php echo e($identificacion); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fecha de nacimiento</th>
                                        <td><?php echo e($fechaNacimiento->format('d/m/Y')); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Edad</th>
                                        <td><?php echo e((string) $edad); ?> años</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sexo</th>
                                        <td><?php echo e($sexo); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Foto guardada como</th>
                                        <td class="text-break small"><code>uploaded_files/<?php echo e($nombreArchivo); ?></code></td>
                                    </tr>
                                </tbody>
                            </table>

                            <a href="index.php" class="btn btn-primary w-100">Registrar otro aspirante</a>
                        </div>
                    </div>
                <?php endif; ?>

                </div>
            </section>
        </div>
    </main>

<?php
// Footer con año dinámico y cierre de </body></html>
include __DIR__ . '/includes/footer.php';
