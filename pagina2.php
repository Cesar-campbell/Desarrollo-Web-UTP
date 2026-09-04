<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Formulario</title>
    <link rel="stylesheet" href="brave-style.css">
</head>
<body>

    <header>
        <h1>Pagina 2</h1>
    </header>

    <div class="container">
        <h2>Resultado del Formulario</h2>

        <div class="resultado">
            <?php
            $Nombre = $_REQUEST['nombre'];
            echo "El nombre es: " . $Nombre . "<br>";

            $Edad = $_POST["edad"];

            if (isset($Edad) and $Edad > 18) {

                //Acciones

                echo "usted puede votar en las próximas elecciones 2028";
            } else echo "Usted no es mayor de edad";
            ?>
        </div>
    </div>

    <footer>Paleta de colores inspirada en Brave Browser</footer>

</body>
</html>
