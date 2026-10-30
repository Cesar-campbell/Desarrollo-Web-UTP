<?php
require __DIR__ . '/config.php';
cabecera('FirmaOtra: certificado X.509 autofirmado');

$campos = [
    'countryName' => ['País (2 letras)', 'PA'],
    'localityName' => ['Localidad', 'Panamá'],
    'organizationName' => ['Organización', 'UTP'],
    'commonName' => ['Nombre común', ''],
    'emailAddress' => ['Correo', ''],
];
?>
<form method="post">
<?php foreach ($campos as $nombre => [$etiqueta, $defecto]): ?>
    <label><?= e($etiqueta) ?></label>
    <input type="text" name="<?= $nombre ?>" value="<?= e($_POST[$nombre] ?? $defecto) ?>" required>
<?php endforeach; ?>
    <label>Días de validez</label>
    <input type="text" name="dias" value="<?= e($_POST['dias'] ?? '365') ?>" required>
    <button>Generar certificado</button>
</form>
<?php
if ($_POST) {
    $dn = [];
    foreach ($campos as $nombre => $_) {
        $dn[$nombre] = $_POST[$nombre] ?? '';
    }
    $dias = max(1, (int) ($_POST['dias'] ?? 365));

    // Par de llaves del certificado
    $par = openssl_pkey_new($configArgs);
    if (!$par) {
        echo '<p class="mal">Error al generar la clave: ' . e((string) openssl_error_string()) . '</p>';
        pie();
        exit;
    }
    openssl_pkey_export($par, $privada, null, $configArgs);

    // CSR (solicitud) y certificado autofirmado con la misma llave
    $csr = openssl_csr_new($dn, $par, $configArgs);
    $cert = $csr ? openssl_csr_sign($csr, null, $par, $dias, $configArgs) : false;
    if (!$cert) {
        echo '<p class="mal">Error al crear el certificado: ' . e((string) openssl_error_string()) . '</p>';
        pie();
        exit;
    }
    openssl_x509_export($cert, $certPem);

    file_put_contents(__DIR__ . '/keysCert/certout.csr', $certPem);
    file_put_contents(__DIR__ . '/keysCert/privkey.pem', $privada);

    $info = openssl_x509_parse($cert);
    echo '<h2>Certificado generado</h2>';
    echo '<p>Válido desde ' . date('Y-m-d', $info['validFrom_time_t']) . ' hasta ' . date('Y-m-d', $info['validTo_time_t']) . '</p>';
    echo '<p>Certificado (PEM):</p><pre>' . e($certPem) . '</pre>';
    echo '<p>Llave privada:</p><pre>' . e($privada) . '</pre>';
    echo '<p>Datos del sujeto:</p><pre>' . e(print_r($info['subject'], true)) . '</pre>';
}
pie();
