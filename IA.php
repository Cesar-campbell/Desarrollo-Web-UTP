<?php
// Iniciamos la sesión para recordar la conversación entre envíos de formulario
session_start();

// Si la conversación no existe en la sesión, la inicializamos
if (!isset($_SESSION['chat'])) {
    $_SESSION['chat'] = [];
}

// Base de conocimientos de la IA
$respuestas_ia = [
    "hola"   => "¡Hola! ¿Cómo estás? ¿En qué puedo ayudarte hoy?",
    "clima"  => "No tengo acceso a satélites, pero espero que haga un buen día.",
    "nombre" => "Soy una IA básica web programada en PHP, HTML y CSS.",
    "adios"  => "¡Adiós! Que tengas un excelente día."
];

// Procesamos el formulario cuando el usuario envía un mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['mensaje'])) {
    $entrada_usuario = trim($_POST['mensaje']);
    $texto_minusculas = strtolower($entrada_usuario);
    $respuesta_ia = "Lo siento, no entiendo esa pregunta. Prueba con: hola, clima, nombre o adios.";

    // Buscar coincidencia de palabras clave
    foreach ($respuestas_ia as $palabra_clave => $respuesta) {
        if (str_contains($texto_minusculas, $palabra_clave)) {
            $respuesta_ia = $respuesta;
            break;
        }
    }

    // Guardamos el mensaje del usuario y la respuesta en la sesión
    $_SESSION['chat'][] = ['rol' => 'usuario', 'texto' => $entrada_usuario];
    $_SESSION['chat'][] = ['rol' => 'ia', 'texto' => $respuesta_ia];
    
    // Redirección para evitar que el mensaje se vuelva a enviar si el usuario recarga la página
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA Básica en PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chat-container {
            width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .chat-header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
        }
        .chat-box {
            height: 350px;
            padding: 15px;
            overflow-y: auto;
            border-bottom: 1px solid #eee;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .msg {
            padding: 10px 14px;
            border-radius: 15px;
            max-width: 75%;
            word-wrap: break-word;
        }
        .usuario {
            background: #007bff;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 0;
        }
        .ia {
            background: #e9ecef;
            color: #333;
            align-self: flex-start;
            border-bottom-left-radius: 0;
        }
        .chat-form {
            display: flex;
            padding: 10px;
            background: #fff;
        }
        .chat-form input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        .chat-form button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">Asistente IA PHP</div>
    
    <div class="chat-box" id="chatBox">
        <?php if (empty($_SESSION['chat'])): ?>
            <div class="msg ia">¡Hola! Escribe un mensaje para empezar a hablar conmigo.</div>
        <?php else: ?>
            <?php foreach ($_SESSION['chat'] as $mensaje): ?>
                <div class="msg <?php echo $mensaje['rol']; ?>">
                    <?php echo htmlspecialchars($mensaje['texto']); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <form class="chat-form" method="POST" action="">
        <input type="text" name="mensaje" placeholder="Escribe un mensaje..." required autofocus autocomplete="off">
        <button type="submit">Enviar</button>
    </form>
</div>

<script>
    // Código opcional en JS para mantener el scroll siempre abajo al cargar nuevos mensajes
    const chatBox = document.getElementById('chatBox');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>

</body>
</html>
