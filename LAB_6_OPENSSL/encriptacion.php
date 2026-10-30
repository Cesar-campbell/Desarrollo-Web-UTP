<?php
require __DIR__ . '/config.php';
cabecera('Encriptación simple con OpenSSL (AES-256-CBC)');

$texto = $_POST['texto'] ?? '';
$clave = $_POST['clave'] ?? '';
?>
<form method="post">
    <label>Texto a cifrar</label>
    <input type="text" name="texto" value="<?= e($texto ?: 'Mensaje secreto') ?>" required>
    <label>Clave secreta</label>
    <input type="text" name="clave" value="<?= e($clave ?: 'clave123456789012') ?>" required>
    <button>Cifrar y descifrar</button>
</form>
<?php
if ($texto !== '' && $clave !== '') {
    $metodo = 'AES-256-CBC';
    // AES-256 necesita una clave de 32 bytes: se deriva de la clave escrita con SHA-256
    $claveBin = hash('sha256', $clave, true);
    // El IV debe ser aleatorio y distinto en cada cifrado
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodo));

    $cifrado = openssl_encrypt($texto, $metodo, $claveBin, OPENSSL_RAW_DATA, $iv);
    // Se guarda IV + cifrado en base64 para poder descifrar después
    $paquete = base64_encode($iv . $cifrado);

    // Descifrado: se separa el IV (primeros bytes) del texto cifrado
    $bin = base64_decode($paquete);
    $ivLen = openssl_cipher_iv_length($metodo);
    $descifrado = openssl_decrypt(substr($bin, $ivLen), $metodo, $claveBin, OPENSSL_RAW_DATA, substr($bin, 0, $ivLen));

    echo '<h2>Resultado</h2>';
    echo '<p>Algoritmo: ' . $metodo . '</p>';
    echo '<p>IV (hex):</p><pre>' . bin2hex($iv) . '</pre>';
    echo '<p>Cifrado (IV + datos, base64):</p><pre>' . e($paquete) . '</pre>';
    echo '<p>Descifrado:</p><pre class="ok">' . e((string) $descifrado) . '</pre>';
}
pie();
