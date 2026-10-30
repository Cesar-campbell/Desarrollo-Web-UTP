<?php
require __DIR__ . '/config.php';
cabecera('FirmarMensaje: firmar con la llave privada y verificar con el certificado');

$mensaje = $_POST['mensaje'] ?? '';
$verificar = $_POST['verificar'] ?? $mensaje;

// Requiere haber ejecutado antes firmaOtra.php
$rutaPriv = __DIR__ . '/keysCert/privkey.pem';
$rutaCert = __DIR__ . '/keysCert/certout.csr';
if (!is_file($rutaPriv) || !is_file($rutaCert)) {
    echo '<p class="mal">Primero genera el certificado en <a href="firmaOtra.php">FirmaOtra</a>.</p>';
    pie();
    exit;
}
?>
<form method="post">
    <label>Mensaje a firmar</label>
    <textarea name="mensaje" rows="2" required><?= e($mensaje ?: 'Este es un mensaje confidencial') ?></textarea>
    <label>Mensaje a verificar (cámbialo para probar una firma inválida)</label>
    <textarea name="verificar" rows="2"><?= e($verificar) ?></textarea>
    <button>Firmar y verificar</button>
</form>
<?php
if ($mensaje !== '') {
    // Firmar con la llave privada
    $privada = openssl_pkey_get_private(file_get_contents($rutaPriv));
    openssl_sign($mensaje, $firmaBin, $privada, OPENSSL_ALGO_SHA256);
    $firmaB64 = base64_encode($firmaBin);

    // Verificar con la llave pública extraída del certificado
    $publica = openssl_pkey_get_public(file_get_contents($rutaCert));
    $ok = openssl_verify($verificar, base64_decode($firmaB64), $publica, OPENSSL_ALGO_SHA256);

    echo '<h2>Resultado</h2><p>Firma en base64:</p><pre>' . e($firmaB64) . '</pre>';
    if ($ok === 1) {
        echo '<p class="ok">Firma válida. El mensaje no fue alterado.</p>';
    } elseif ($ok === 0) {
        echo '<p class="mal">Firma inválida. El mensaje pudo haber sido modificado.</p>';
    } else {
        echo '<p class="mal">Error al verificar la firma: ' . e((string) openssl_error_string()) . '</p>';
    }
}
pie();
