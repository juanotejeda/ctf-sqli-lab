<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remote Execution - ¿Qué es SQL Injection?</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* --- Mantener el diseño y colores del lab principal --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #181818; color: #fff; min-height: 100vh; }
        header { background: rgba(24,24,24,0.95); border-bottom: 1px solid rgba(0,255,136,.2); position: fixed; width: 100%; top: 0; z-index: 1000; }
        .header-content { max-width: 1200px; margin:0 auto; display: flex; justify-content: space-between; align-items:center; padding: 1rem 2rem; }
        .logo img { width: 50px; height: 50px; border-radius: 8px; border:2px solid rgba(255,71,87,.3); margin-right:1rem; }
        .logo h1 { font-size: 1.8rem; font-weight: 700; background: linear-gradient(45deg,#00ff88,#00d4ff); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip: text;}
        .nav-links { display: flex; gap: 2rem; list-style: none;}
        .nav-links a { color: #fff; text-decoration: none; font-weight: 500; transition: all .25s; }
        .nav-links a:hover { color: #00ff88; }
        main { margin-top: 95px; padding: 3rem 0; }
        .container { max-width: 980px; margin:0 auto; padding: 0 2rem; }
        h1, h2, h3 { font-weight: 800;}
        h1 { font-size: 2.9rem; margin-bottom: .7em; border-bottom: 3px solid #00ff88; width: fit-content; }
        h2, h3 { margin-top: 2rem; margin-bottom:.6rem;}
        h2 { color: #00ff88; font-size:1.7rem;}
        h3 { color:#ff4757; font-size:1.2rem;}
        .hero-desc { font-size:1.23rem;color:#a0a0a0; margin-bottom:2.3rem; }
        .payload-table { width:100%; background:rgba(24,24,24,0.92); border-collapse:collapse; margin-bottom:2.2em;}
        .payload-table th, .payload-table td { border:1px solid #333; padding:.8em; text-align:left;}
        .payload-table th { background:#00ff8835; color:#00ff88;}
        .payload-table tr td:first-child {color:#ff5e6b; }
        .payload-table tr td:last-child { color:#aaa;}
        .mitigation-list li {margin-bottom:.9em;}
        code, pre { background:#181818; color: #fff; border-radius:5px; padding:3px 7px; font-size:1em;}
        .objective-box { 
            background:rgba(0,255,136,0.09); 
            border:1px solid rgba(0,255, 136,.26); 
            border-radius:12px;
            padding:1.6em 1.3em;
            margin:2em 0;
        }
        .tip { color:#ffa502; font-style:italic;}
        footer {background:rgba(24,24,24,0.95);border-top:1px solid rgba(0,255,136,.2);padding:2.1rem 0 .9rem;text-align:center;margin-top:2.5em;}
        .footer-content {max-width:1200px;margin:0 auto;padding:0 2rem;color:#aaa;}
        @media (max-width:800px){
            .container{padding:0 0.6rem;}
            h1{font-size:2rem;}
            .header-content{flex-direction:column; align-items:flex-start;}
            main{padding:2rem 0;}
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="https://media.licdn.com/dms/image/v2/D4D0BAQGHUENLKJGxhw/company-logo_200_200/B4DZbO8rLzGUAI-/0/1747228736601/remoteexecution_logo?e=2147483647&v=beta&t=GgVfARUIOn7B77Rk7ND99aUiZ-IG49D8V0XNvJUYfGk" alt="Remote Execution Logo">
                <h1>Remote Execution</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php#home">Inicio</a></li>
                    <li><a href="index.php#challenge">Reto</a></li>
                    <li><a href="index.php#social">Comunidad</a></li>
                    <li><a href="index.php#contact">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <h1 class="glitch">¿Qué es SQL Injection?</h1>
            <p class="hero-desc">
                <b>SQL Injection (Inyección SQL)</b> es una vulnerabilidad que permite a un atacante manipular sentencias SQL inyectando código malicioso a través de los campos de entrada de una aplicación web. Esto se debe a la falta de validación y sanitizado adecuado en las consultas a la base de datos. Un atacante puede, por ejemplo, eludir la autenticación, consultar o modificar datos sensibles e incluso tomar el control del servidor de base de datos.
            </p>

            <div class="objective-box">
                <h2><i class="fas fa-exclamation-triangle"></i> ¿Cómo funciona la SQLi?</h2>
                <p>
                    Cuando una aplicación construye consultas SQL concatenando directamente el input del usuario, el atacante puede alterar la lógica prevista. Ejemplo típico vulnerable:
                </p>
                <pre><code>
$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
                </code></pre>
                <p>
                    Si no se controla el valor recibido, ingresando un texto especial puede “romper” la consulta:
                </p>
                <pre><code>
Usuario: admin' --
Password: (vacío)
                </code></pre>
                <p>
                    Lo que genera (bypass de autenticación):
                </p>
                <pre><code>
SELECT * FROM users WHERE username = 'admin' -- ' AND password = '';
                </code></pre>
                <span class="tip">El doble guion <code>--</code> inicia un comentario en SQL, ignorando la verificación de contraseña.</span>
            </div>

            <h2>Payloads & Lógica Explicada</h2>
            <table class="payload-table">
                <tr>
                    <th>Payload (En Usuario)</th>
                    <th>Lógica/Resultado</th>
                </tr>
                <tr>
                    <td>admin' -- </td>
                    <td>Accede como admin y comenta el resto (bypassea contraseña)</td>
                </tr>
                <tr>
                    <td>admin' #</td>
                    <td>Comentarios de línea en SQL (igual que -- pero con <b>#</b>)</td>
                </tr>
                <tr>
                    <td>admin' or '1'='1</td>
                    <td>Hace que la condición sea siempre verdadera, accediendo como cualquier usuario</td>
                </tr>
                <tr>
                    <td>' OR 1=1--</td>
                    <td>Usado si no se conoce usuario, da acceso a la primera cuenta encontrada</td>
                </tr>
                <tr>
                    <td>admin' or 1=1 #</td>
                    <td>Bypassea todo el login usando lógica booleana y comentario</td>
                </tr>
            </table>
            <p class="tip" style="margin-bottom:2em;">Siempre revisa la sintaxis: a veces es necesario un espacio tras <code>--</code> o <code>#</code> para que MySQL lo interprete como comentario.</p>


            <h2>¿Cómo mitigar la Inyección SQL?</h2>
            <ul class="mitigation-list">
                <li><b>Usa consultas preparadas</b> (prepared statements): Separa los datos de la lógica SQL.<br>
                <span style="color:#aaa">Ejemplo en PHP/MySQLi:</span>
                <pre><code>
$stmt = $db->prepare(
  "SELECT * FROM users WHERE username = ? AND password = ?"
);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
                </code></pre>
                </li>
                <li><b>Valida y sanitiza el input</b>: Nunca confíes en los datos enviados por los usuarios.</li>
                <li><b>Principio de privilegios mínimos</b>: El usuario de la DB no debe tener más permisos que los necesarios.</li>
                <li><b>Evita mostrar mensajes de error sensibles</b>: No reveles detalles de la SQL en respuestas al usuario final.</li>
                <li><b>Monitorea y loguea todos los accesos y errores</b> en los endpoints críticos.</li>
            </ul>

            <div class="objective-box">
                <h3><i class="fas fa-shield-alt"></i>Recuerda:</h3>
                <ul>
                    <li>Haz siempre tus pruebas en entornos controlados.</li>
                    <li>No uses técnicas de hacking fuera del laboratorio o la formación autorizada.</li>
                </ul>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-content">
            &copy; 2025 Remote Execution. Desarrollado por <strong>Juano.exe</strong> | Uso sólo educativo.
        </div>
    </footer>
</body>
</html>
