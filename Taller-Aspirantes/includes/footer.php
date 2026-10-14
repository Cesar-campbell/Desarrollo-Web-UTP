<?php
if (!defined('INCLUDED_FROM_APP')) {
    http_response_code(403);
    die('Acceso denegado: No puedes ver este archivo directamente.');
}
?>
    <footer class="bg-dark text-white pt-4 pb-3 mt-auto">
        <div class="container">
            <div class="row gy-4">

                <div class="col-md-6">
                    <p class="fw-semibold mb-1">Portal de Gestión de Aspirantes</p>
                    <p class="small text-white-50 mb-0">
                        Registro seguro de aspirantes de la Licenciatura en Ciberseguridad,
                        Facultad de Ingeniería de Sistemas Computacionales, Universidad Tecnológica de Panamá.
                    </p>
                </div>

                <div class="col-6 col-md-3">
                    <p class="fw-semibold mb-2">Enlaces rápidos</p>
                    <ul class="list-unstyled small mb-0">
                        <li><a href="index.php" class="text-white-50 text-decoration-none">Inicio</a></li>
                        <li><a href="index.php#registro" class="text-white-50 text-decoration-none">Registro de aspirantes</a></li>
                        <li><a href="https://utp.ac.pa" target="_blank" rel="noopener noreferrer" class="text-white-50 text-decoration-none">Sitio de la UTP</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3">
                    <p class="fw-semibold mb-2">Contacto</p>
                    <a href="https://github.com" target="_blank" rel="noopener noreferrer"
                       class="text-white fs-5 me-3" aria-label="GitHub"><i class="bi bi-github"></i></a>
                    <a href="mailto:cesar.campell@utp.ac.pa"
                       class="text-white fs-5" aria-label="Correo de soporte técnico"><i class="bi bi-envelope-fill"></i></a>
                </div>
            </div>

            <hr class="border-secondary my-3">

            <p class="text-white-50 small text-center mb-0">
                &copy; <?php echo date('Y'); ?> Universidad Tecnológica de Panamá. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    <script src="https://jsdelivr.net"></script>

</body>
</html>
