<?php
class Circulo {
    private float $radio;

    public function __construct(float $radio) {
        $this->radio = $radio;
    }

    public function calcularArea(): float {
        return M_PI * ($this->radio * $this->radio);
    }

    public function calcularPerimetro(): float {
        return 2 * M_PI * $this->radio;
    }
}

$miCirculo = new Circulo(4);

echo "Área del círculo: \t"     . number_format($miCirculo->calcularArea(),      2, '.', ',') . "\n";
echo "Perímetro del círculo: \t" . number_format($miCirculo->calcularPerimetro(), 2, '.', ',') . "\n";
?>