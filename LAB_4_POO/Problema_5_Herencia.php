<?php
final class Coche {
    public function getColor() {
        echo 'Rojo';
    }
}

class cocheDeLujo extends Coche {
}

$miCoche = new Coche();
$miCoche->getColor();
?>