<?php

$var = 0;

//se evalue true ya que $var esta vacia
if (isset($var)) {
    echo "$var es bien 0, vacia, o no se encuentra definida en absoluto\n";
}

//se evalua como true ya que $var esta definida
if (isset($var)) {
echo "$var esta definida a pesar de que esta vacia\n"
;

}
?>