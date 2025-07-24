<?php http_response_code(500); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error 500 – Interno del sistema</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #181818; color: #fff; text-align:center; font-family:'Segoe UI', Arial, sans-serif;}
        .wrapper { margin-top: 11vh;}
        h1 { font-size: 3rem; color: #ff4757; margin-bottom:.8em;}
        .icon500 { font-size:4.2rem; color:#ffa502; }
        .clue { color:#ffa502; margin-top:2em; font-size:1.13rem;}
        .back-link { color: #00ff88; margin-top:2em;display:inline-block;
            background: rgba(0,255,136,.17); padding:.8em 2em; border-radius:8px; text-decoration: none; font-weight: bold; border:1px solid #00ff88;}
        .back-link:hover { background: #00ff88; color: #181818;}
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="icon500"><i class="fas fa-bug"></i></div>
        <h1>Error 500: ¡Algo inesperado pasó!</h1>
        <p>¿Intentaste algo arriesgado? Tal vez encontraste un camino que solo los hackers ven...</p>
        <div class="clue">
            Recuerda: A veces los errores son la pista para un exploit exitoso.
        </div>
        <a class="back-link" href="index.php"><i class="fas fa-arrow-left"></i> Volver al laboratorio</a>
    </div>
</body>
</html>
