<?php
/**
 * index.php
 * ------------------------------------------------------------------
 * Página principal con el formulario visual de registro.
 * Estructura semántica: <header> (include) -> <main><section> -> <footer> (include)
 * ------------------------------------------------------------------
 */

// Definimos el "permiso" ANTES de llamar a los includes.
// Los archivos de includes/ verifican esta constante para no ejecutarse solos.
define('INCLUDED_FROM_APP', true);

// Navegación: <head>, <header>, Navbar y Breadcrumb dinámico
include __DIR__ . '/includes/header.php';
?>

    <main class="flex-grow-1 d-flex align-items-center py-5">
        <div class="container">
            <section id="registro" class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <?php
                    // El formulario
                    include __DIR__ . '/includes/formulario.php';
                    ?>
                </div>
            </section>
        </div>
    </main>

<?php
// Footer: <footer> con año dinámico y cierre de </body></html>
include __DIR__ . '/includes/footer.php';
