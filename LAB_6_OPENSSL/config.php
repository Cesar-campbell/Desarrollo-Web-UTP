<?php
// Configuración común de OpenSSL y funciones de la interfaz.
// Si OpenSSL no encuentra openssl.cnf (pasa en algunos XAMPP de Windows), se busca en rutas comunes.
$configArgs = [
    'private_key_bits' => 2048,
    'private_key_type' => OPENSSL_KEYTYPE_RSA,
    'digest_alg' => 'sha256', // sin esto csr_new/csr_sign pueden fallar con "invalid digest"
];

// Algunos PHP/OpenSSL fallan al crear CSR si no existe el archivo de aleatoriedad (~/.rnd)
$randFile = sys_get_temp_dir() . '/lab_openssl.rnd';
if (!is_file($randFile)) {
    file_put_contents($randFile, random_bytes(1024));
}
putenv('RANDFILE=' . $randFile);

if (PHP_OS_FAMILY === 'Windows') {
    $rutas = [
        'C:\\xampp\\php\\extras\\ssl\\openssl.cnf',
        'D:\\xampp\\php\\extras\\ssl\\openssl.cnf',
        'C:\\OpenSSL-Win64\\bin\\cnf\\openssl.cnf',
        dirname(PHP_BINARY) . '\\extras\\ssl\\openssl.cnf',
    ];
    foreach ($rutas as $ruta) {
        if (is_file($ruta)) {
            $configArgs['config'] = $ruta;
            break;
        }
    }
}

// Escapa texto para mostrarlo en HTML
function e(string $t): string
{
    return htmlspecialchars($t, ENT_QUOTES, 'UTF-8');
}

// Cabecera y pie comunes de cada página
function cabecera(string $titulo): void
{
    echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><title>' . e($titulo) . '</title>
<style>
body{font-family:sans-serif;max-width:860px;margin:2rem auto;padding:0 1rem;color:#222}
label{display:block;margin-top:.8rem;font-weight:bold}
input[type=text],textarea{width:100%;padding:.4rem;box-sizing:border-box}
button{margin-top:1rem;padding:.5rem 1.2rem}
pre{background:#f3f3f3;padding:.8rem;overflow-x:auto;white-space:pre-wrap;word-break:break-all}
.ok{color:#0a7a2f;font-weight:bold}.mal{color:#b00020;font-weight:bold}
nav a{margin-right:1rem}
</style></head><body>
<nav><a href="encriptacion.php">Encriptación</a><a href="firma7.php">Firma7</a><a href="firmaOtra.php">FirmaOtra (certificado)</a><a href="firmarMensaje.php">FirmarMensaje</a><a href="sodium.php">Sodium</a></nav>
<h1>' . e($titulo) . '</h1>';
}

function pie(): void
{
    echo '</body></html>';
}
