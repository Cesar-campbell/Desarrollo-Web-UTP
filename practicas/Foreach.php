<?php

//Array de animales que recorreremos.
$animals = array('gato', 'perro', 'huron', 'ardilla');

//Recorremos el array con un foreach
foreach ($animals as $key=> $animal) {
    $animals[$key] = ucfirst($animal);
}

print_r($animals);
?>