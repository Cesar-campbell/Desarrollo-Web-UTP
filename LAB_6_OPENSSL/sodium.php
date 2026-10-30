<?php
require __DIR__ . '/config.php';
cabecera('Libsodium: cifrado autenticado y firma digital');

$texto = $_POST['texto'] ?? '';
?>
<form method="post">
    <label>Texto</label>
    <input type="text" name="texto" value="<?= e($texto ?: 'Dato sensible: tarjeta 4111 1111 1111 1111') ?>" required>
    <label>Contraseña (se convierte en clave con Argon2)</label>
    <input type="text" name="clave" value="<?= e($_POST['clave'] ?? 'mi-clave-segura') ?>" required>
    <button>Cifrar, firmar y verificar</button>
</form>
<?php
if ($texto !== '') {
    // 1. Clave derivada de la contraseña con Argon2 (resistente a fuerza bruta con GPU)
    $sal = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
    $clave = sodium_crypto_pwhash(
        SODIUM_CRYPTO_SECRETBOX_KEYBYTES,
        $_POST['clave'],
        $sal,
        SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
        SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
    );

    // 2. Cifrado autenticado (confidencialidad + integridad en una llamada)
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $cifrado = sodium_crypto_secretbox($texto, $nonce, $clave);
    $claro = sodium_crypto_secretbox_open($cifrado, $nonce, $clave);

    // 3. Si alguien altera el cifrado, el descifrado falla (devuelve false)
    $alterado = $cifrado;
    $alterado[0] = chr(ord($alterado[0]) ^ 1);
    $claroAlterado = sodium_crypto_secretbox_open($alterado, $nonce, $clave);

    // 4. Firma digital Ed25519
    $par = sodium_crypto_sign_keypair();
    $privada = sodium_crypto_sign_secretkey($par);
    $publica = sodium_crypto_sign_publickey($par);
    $firma = sodium_crypto_sign_detached($texto, $privada);
    $firmaOk = sodium_crypto_sign_verify_detached($firma, $texto, $publica);
    $firmaAlteradaOk = sodium_crypto_sign_verify_detached($firma, $texto . 'x', $publica);

    echo '<h2>Cifrado autenticado (XSalsa20-Poly1305)</h2>';
    echo '<p>Cifrado (hex):</p><pre>' . bin2hex($cifrado) . '</pre>';
    echo '<p>Descifrado:</p><pre class="ok">' . e((string) $claro) . '</pre>';
    echo '<p>Descifrado tras alterar 1 bit: <span class="mal">' . ($claroAlterado === false ? 'rechazado (integridad rota)' : 'ERROR') . '</span></p>';

    echo '<h2>Firma digital (Ed25519)</h2>';
    echo '<p>Llave pública (hex):</p><pre>' . bin2hex($publica) . '</pre>';
    echo '<p>Firma (hex):</p><pre>' . bin2hex($firma) . '</pre>';
    echo '<p>Verificación con el texto original: <span class="' . ($firmaOk ? 'ok' : 'mal') . '">' . ($firmaOk ? 'válida' : 'inválida') . '</span></p>';
    echo '<p>Verificación con el texto alterado: <span class="mal">' . ($firmaAlteradaOk ? 'ERROR' : 'inválida') . '</span></p>';
}
pie();
