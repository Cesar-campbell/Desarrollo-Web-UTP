<?php
require __DIR__ . '/config.php';
cabecera('Firma7: par de llaves RSA, firma y verificación');

$datos = $_POST['datos'] ?? '';
?>
<form method="post">
    <label>Datos que se quieren firmar</label>
    <textarea name="datos" rows="3" required><?= e($datos ?: 'Este texto será firmado. Thanks for your attention :)') ?></textarea>
    <button>Generar llaves, firmar y verificar</button>
</form>
<?php
if ($datos !== '') {
    // 1. Se crea el par de llaves (pública y privada)
    $par = openssl_pkey_new($configArgs);
    if (!$par) {
        echo '<p class="mal">Error al crear las llaves: ' . e((string) openssl_error_string()) . '</p>';
        pie();
        exit;
    }
    $detalles = openssl_pkey_get_details($par);
    $publicaPem = $detalles['key'];
    openssl_pkey_export($par, $privadaPem, null, $configArgs);

    // 2. Se guardan en disco
    file_put_contents(__DIR__ . '/keys/private_key.pem', $privadaPem);
    file_put_contents(__DIR__ . '/keys/public_key.pem', $publicaPem);

    // 3. Se firma con la llave privada (SHA-256)
    $privada = openssl_get_privatekey(file_get_contents(__DIR__ . '/keys/private_key.pem'));
    openssl_sign($datos, $firma, $privada, OPENSSL_ALGO_SHA256);
    file_put_contents(__DIR__ . '/keys/signature.dat', $firma);

    // 4. Se verifica con la llave pública
    $ok = openssl_verify($datos, $firma, $publicaPem, OPENSSL_ALGO_SHA256);

    echo '<h2>Resultado</h2>';
    echo '<p>Llave pública:</p><pre>' . e($publicaPem) . '</pre>';
    echo '<p>Llave privada:</p><pre>' . e($privadaPem) . '</pre>';
    echo '<p>Firma (base64):</p><pre>' . e(base64_encode($firma)) . '</pre>';
    echo $ok === 1
        ? '<p class="ok">La firma es válida y los datos son confiables</p>'
        : '<p class="mal">La firma es inválida y/o los datos fueron alterados</p>';
}
pie();
