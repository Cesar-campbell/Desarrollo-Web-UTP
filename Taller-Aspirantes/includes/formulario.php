<?php
/**
 * includes/formulario.php
 * ------------------------------------------------------------------
 * Formulario de Registro de Aspirantes (se incluye dentro de
 * <main><section> en index.php).
 *  - method="POST" porque se envían datos personales y un archivo.
 *  - enctype="multipart/form-data" es OBLIGATORIO para que la foto
 *    viaje al servidor y llegue en $_FILES.
 * ------------------------------------------------------------------
 */

// Seguridad a nivel de componente: bloquea el acceso directo por URL
if (!defined('INCLUDED_FROM_APP')) {
    http_response_code(403);
    die('Acceso denegado: No puedes ver este archivo directamente.');
}
?>
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <h1 class="h4 text-center mb-4">Formulario de Registro de Aspirantes</h1>

        <form action="procesar.php" method="POST" enctype="multipart/form-data">

            <!-- Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre (Requerido):</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                       placeholder="Ej: María José" maxlength="50" autocomplete="given-name" required>
            </div>

            <!-- Apellido -->
            <div class="mb-3">
                <label for="apellido" class="form-label fw-semibold">Apellido (Requerido):</label>
                <input type="text" class="form-control" id="apellido" name="apellido"
                       placeholder="Ej: González Pérez" maxlength="50" autocomplete="family-name" required>
            </div>

            <!-- Identificación -->
            <div class="mb-3">
                <label for="identificacion" class="form-label fw-semibold">Identificación (Requerido):</label>
                <input type="text" class="form-control" id="identificacion" name="identificacion"
                       placeholder="Ej: 8-123-4567 o PE-1-234" maxlength="20" required>
            </div>

            <!-- Fecha de nacimiento (max = hoy, para no aceptar fechas futuras) -->
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento (Requerido):</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                       max="<?php echo date('Y-m-d'); ?>" required>
                <div class="form-text">Debes tener entre 18 y 70 años.</div>
            </div>

            <!-- Sexo: radio buttons con estilo de botones (Bootstrap btn-check) -->
            <fieldset class="mb-3">
                <legend class="form-label fw-semibold fs-6">Sexo (Requerido):</legend>
                <div class="d-flex gap-2">
                    <input type="radio" class="btn-check" name="sexo" id="sexo_hombre" value="Hombre" autocomplete="off" required>
                    <label class="btn btn-outline-primary flex-fill" for="sexo_hombre">Hombre</label>

                    <input type="radio" class="btn-check" name="sexo" id="sexo_mujer" value="Mujer" autocomplete="off">
                    <label class="btn btn-outline-primary flex-fill" for="sexo_mujer">Mujer</label>
                </div>
            </fieldset>

            <!-- Fotografía -->
            <div class="mb-4">
                <label for="foto" class="form-label fw-semibold">Fotografía del Aspirante (png, jpg, jpeg, gif, webp):</label>
                <input type="file" class="form-control" id="foto" name="foto"
                       accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp" required>
                <div class="form-text">Tamaño máximo: 2 MB.</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrar Aspirante</button>
        </form>
    </div>
</div>
