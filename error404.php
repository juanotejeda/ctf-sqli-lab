<?php http_response_code(404); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error 404 – Página no encontrada</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #181818; color: #fff; text-align: center; font-family: 'Segoe UI', Arial, sans-serif; }
        .wrapper { margin-top: 11vh;}
        h1 { font-size: 4rem; color: #ff4757; margin-bottom: 1em;}
        .icon404 { font-size:5rem;color:#00ff88; }
        p { font-size: 1.2rem; margin-bottom:2.5em;}
        .challenge-hint { margin-top:2em; color: #00ff88; font-size:1.1em;}
        a.back-link {
            color: #00ff88;
            background: rgba(0,255,136,.12);
            padding: .7em 1.5em;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            margin-top: 3em; display: inline-block;
            border: 1px solid #00ff88;
        }
        a.back-link:hover { background: #00ff88; color: #181818; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="icon404"><i class="fas fa-user-secret"></i></div>
        <h1>Error 404</h1>
        <p>¡Ups! Parece que has tomado un camino desconocido en el desafío.<br>
        En seguridad, perderse es parte del aprendizaje.</p>
        <div class="challenge-hint">
            Pista: <b>Incluso los errores esconden secretos.</b>
        </div>
        <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Volver al laboratorio</a>
    </div>
</body>
</html>
