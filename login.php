<?php
// Manejo global de errores y excepciones 
set_exception_handler(function($e) {
    include 'error500.php';
    exit;
});
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    include 'error500.php';
    exit;
});
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        include 'error500.php';
        exit;
    }
});
$resultado_login = "";
$db = new mysqli('localhost', 'dbuser', 'dbpassword', 'sqli_lab');
if ($db->connect_error) {
    $resultado_login .= '<div style="color:red;font-weight:bold;">Error de conexión: ' . htmlspecialchars($db->connect_error) . '</div>';
} else {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $resultado_login .= "<p><strong>Consulta ejecutada:</strong><br>
        <code style='background:#181818;border-radius:5px;display:block;padding:7px 12px;margin-top:7px;word-break:break-all;'>"
        . htmlspecialchars($sql) . "</code></p>";

    $result = $db->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['username'] === 'admin') {
            $resultado_login .= "<p style='color:#00ff88;font-weight:bold;font-size:1.22em;margin:0.8em 0;'>¡Acceso concedido como admin!</p>";
            $resultado_login .= "<div style='background:#00ff8840;border-radius:10px;padding:1.2em 1em;margin:1.3em 0;color:#222;font-weight:bold;font-size:1.1em;letter-spacing:1px;text-align:center;'>La flag es:<br><span style=\"color:#fff;background:#222;padding:2px 8px;border-radius:6px;margin-left:7px;\">"
                . htmlspecialchars($row['flag']) . "</span></div>";
        } else {
            $resultado_login .= "<p>Acceso concedido como usuario <b>" . htmlspecialchars($row['username']) . "</b>. Sin flag.</p>";
        }
    } else {
        $resultado_login .= "<p style='color:#ff4757;font-weight:bold;margin:1.1em 0;'>Acceso denegado</p>";
        $resultado_login .= "<p>Usuario o contraseña incorrectos, o la inyección aún no es correcta.</p>";
    }
    $db->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remote Execution - SQL Injection CTF</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #181818; color: #ffffff; min-height: 100vh; overflow-x: hidden; }
        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; opacity: 0.1; }
        .particle { position: absolute; width: 2px; height: 2px; background: #00ff88; border-radius: 50%; animation: float 6s ease-in-out infinite;}
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(180deg); } }
        header { background: rgba(24,24,24,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,255,136,0.2); padding: 1rem 0; position: fixed; width: 100%; top: 0; z-index: 1000; transition: all 0.3s ease;}
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 2rem;}
        .logo { display: flex; align-items: center; gap: 1rem; }
        .logo img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 2px solid rgba(255,71,87,0.3); box-shadow: 0 0 20px rgba(255,71,87,0.3);}
        .logo h1 { font-size: 1.8rem; font-weight: 700; background: linear-gradient(45deg, #00ff88, #00d4ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;}
        .nav-links { display: flex; gap: 2rem; list-style: none;}
        .nav-links a { color: #ffffff; text-decoration: none; font-weight: 500; transition: all 0.3s ease; position: relative;}
        .nav-links a:hover { color: #00ff88; transform: translateY(-2px);}
        .nav-links a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 2px; background: linear-gradient(45deg, #00ff88, #00d4ff); transition: width 0.3s ease;}
        .nav-links a:hover::after { width: 100%; }
        main { margin-top: 80px; padding: 4rem 0;}
        .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem;}
        .hero { text-align: center; padding: 4rem 0; position: relative;}
        .hero::before {content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 300px; height: 300px; background: radial-gradient(circle,rgba(0,255,136,0.1)0%,transparent 70%); border-radius: 50%; z-index: -1;}
        .hero-logo { width: 120px; height:120px; margin: 0 auto 2rem; border-radius: 20px; object-fit: cover; border: 3px solid rgba(255,71,87,0.5); box-shadow: 0 0 40px rgba(255,71,87,0.4); animation: pulse-logo 3s ease-in-out infinite;}
        @keyframes pulse-logo { 0%,100%{transform:scale(1);box-shadow:0 0 40px rgba(255,71,87,0.4);} 50%{transform:scale(1.05);box-shadow:0 0 60px rgba(255,71,87,0.6);} }
        .hero h1 { font-size: 4rem; font-weight:800; margin-bottom: 1rem; background: linear-gradient(45deg, #ff4757,#ff6b7a,#00ff88); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow:0 0 30px rgba(255,71,87,0.3);}
        .hero .subtitle { font-size: 1.5rem; color: #a0a0a0; margin-bottom: 2rem; font-weight: 300;}
        .hero .hashtag { font-size: 2rem; color: #00ff88; font-weight:600; margin-bottom: 3rem; text-shadow:0 0 20px rgba(0,255,136,0.5);}
        .challenge-section { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin: 4rem 0;}
        .challenge-info { background: rgba(24,24,24,0.9); border-radius: 20px; padding: 2.5rem; border: 1px solid rgba(0,255,136,0.2); backdrop-filter: blur(10px); position: relative; overflow: hidden;}
        .challenge-info::before { content: ''; position: absolute; top: 0; left: 0; right:0; height:3px; background: linear-gradient(90deg,#ff4757,#00ff88,#00d4ff);}
        .challenge-info h2 { font-size: 2rem; margin-bottom: 1.5rem; color: #00ff88; display: flex; align-items: center; gap: 1rem;}
        .challenge-info h2 i { font-size:1.5rem; color:#ff4757;}
        .challenge-description { font-size:1.1rem; line-height:1.8; color:#e0e0e0; margin-bottom:2rem;}
        .objective-box {background:rgba(255,71,87,0.1);border:1px solid rgba(255,71,87,0.3);border-radius:15px;padding:1.5rem;margin-top:2rem;}
        .objective-box h3 {color:#ff4757;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;}
        .objective-box p {color:#f0f0f0;line-height:1.6;}
        .login-panel {background:rgba(24,24,24,0.9);border-radius:20px;padding:2.5rem;border:1px solid rgba(255,71,87,0.3);backdrop-filter:blur(10px);position:relative;overflow:hidden;}
        .login-panel::before {content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#ff4757,#ff6b7a);}
        .login-panel h2 {font-size:2rem;margin-bottom:2rem;color:#ff4757;text-align:center;display:flex;align-items:center;justify-content:center;gap:1rem;}
        .form-group {margin-bottom:1.5rem;}
        .form-group label {display:block;margin-bottom:.5rem;color:#e0e0e0;font-weight:500;}
        .form-group input {width:100%;padding:1rem;background:rgba(24,24,24,0.8);border:1px solid rgba(255,255,255,0.1);border-radius:10px;color:#ffffff;font-size:1rem;transition:all 0.3s ease;}
        .form-group input:focus {outline:none;border-color:#00ff88;box-shadow:0 0 20px rgba(0,255,136,0.2);transform:translateY(-2px);}
        .login-btn {width:100%;padding:1rem;background:linear-gradient(45deg,#ff4757,#ff6b7a);border:none;border-radius:10px;color:#ffffff;font-size:1.1rem;font-weight:600;cursor:pointer;transition:all 0.3s ease;text-transform:uppercase;letter-spacing:1px;}
        .login-btn:hover {transform:translateY(-3px);box-shadow:0 10px 30px rgba(255,71,87,0.4);}
        .warning-text {text-align:center;margin-top:1rem;color:#ffa502;font-size:0.9rem;font-style:italic;}
        .social-section {text-align:center;padding:4rem 0;background:rgba(24,24,24,0.7);margin:4rem 0;border-radius:20px;border:1px solid rgba(0,255,136,0.1);}
        .social-section h2 {font-size:2.5rem;margin-bottom:2rem;color:#00ff88;}
        .social-links {display:flex;justify-content:center;gap:2rem;flex-wrap:wrap;}
        .social-link {display:flex;align-items:center;gap:1rem;padding:1rem 2rem;background:rgba(24,24,24,0.9);border-radius:15px;text-decoration:none;color:#ffffff;transition:all 0.3s ease;border:1px solid rgba(255,255,255,0.1);}
        .social-link:hover {transform:translateY(-5px);box-shadow:0 15px 40px rgba(0,0,0,0.3);}
        .social-link.twitter:hover {border-color:#1da1f2;box-shadow:0 15px 40px rgba(29,161,242,0.3);}
        .social-link.github:hover {border-color:#333;box-shadow:0 15px 40px rgba(51,51,51,0.3);}
        .social-link.discord:hover {border-color:#7289da;box-shadow:0 15px 40px rgba(114,137,218,0.3);}
        .social-link.linkedin:hover {border-color:#0077b5;box-shadow:0 15px 40px rgba(0,119,181,0.3);}
        .social-link i {font-size:1.5rem;}
        footer {background:rgba(24,24,24,0.95);border-top:1px solid rgba(0,255,136,0.2);padding:3rem 0 1rem;text-align:center;}
        .footer-content {max-width:1200px;margin:0 auto;padding:0 2rem;}
        .footer-info {display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:2rem;margin-bottom:2rem;}
        .footer-section h3 {color:#00ff88;margin-bottom:1rem;font-size:1.2rem;}
        .footer-section p,.footer-section a {color:#a0a0a0;text-decoration:none;line-height:1.6;}
        .footer-section a:hover {color:#00ff88;}
        .footer-bottom {border-top:1px solid rgba(255,255,255,0.1);padding-top:1rem;color:#666;}
        @media (max-width:768px) {
            .header-content {flex-direction:column;gap:1rem;}
            .nav-links {gap:1rem;}
            .hero h1 {font-size:2.5rem;}
            .hero .subtitle {font-size:1.2rem;}
            .hero-logo {width:80px;height:80px;}
            .challenge-section {grid-template-columns:1fr;gap:2rem;}
            .social-links {flex-direction:column;align-items:center;}
            .footer-info {grid-template-columns:1fr;text-align:center;}
        }
        .glitch {position:relative;animation:glitch 2s infinite;}
        @keyframes glitch {0%,100%{transform:translate(0);}20%{transform:translate(-2px,2px);}40%{transform:translate(-2px,-2px);}60%{transform:translate(2px,2px);}80%{transform:translate(2px,-2px);}}
        .pulse {animation:pulse 2s infinite;}
        @keyframes pulse {0%{box-shadow:0 0 0 0 rgba(0,255,136,0.7);}70%{box-shadow:0 0 0 10px rgba(0,255,136,0);}100%{box-shadow:0 0 0 0 rgba(0,255,136,0);}}
    </style>
</head>
<body>
    <div class="particles">
        <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
        <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
        <div class="particle" style="left: 40%; animation-delay: 3s;"></div>
        <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
        <div class="particle" style="left: 60%; animation-delay: 5s;"></div>
        <div class="particle" style="left: 70%; animation-delay: 0.5s;"></div>
        <div class="particle" style="left: 80%; animation-delay: 1.5s;"></div>
        <div class="particle" style="left: 90%; animation-delay: 2.5s;"></div>
    </div>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="https://media.licdn.com/dms/image/v2/D4D0BAQGHUENLKJGxhw/company-logo_200_200/B4DZbO8rLzGUAI-/0/1747228736601/remoteexecution_logo?e=2147483647&v=beta&t=GgVfARUIOn7B77Rk7ND99aUiZ-IG49D8V0XNvJUYfGk" alt="Remote Execution Logo">
                <h1>Remote Execution</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#home">Inicio</a></li>
                    <li><a href="#challenge">Reto</a></li>
                    <li><a href="#social">Comunidad</a></li>
                    <li><a href="#contact">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="hero" id="home">
                <img src="https://media.licdn.com/dms/image/v2/D4D0BAQGHUENLKJGxhw/company-logo_200_200/B4DZbO8rLzGUAI-/0/1747228736601/remoteexecution_logo?e=2147483647&v=beta&t=GgVfARUIOn7B77Rk7ND99aUiZ-IG49D8V0XNvJUYfGk" alt="Remote Execution Logo" class="hero-logo">
                <h1 class="glitch">SQL Injection CTF</h1>
                <p class="subtitle">Laboratorio de Ciberseguridad Avanzada</p>
                <div class="hashtag">#RemoteExecution</div>
            </section>
            <section class="challenge-section" id="challenge">
                <div class="challenge-info">
                    <h2><i class="fas fa-database"></i>Descripción del Reto</h2>
                    <div class="challenge-description">
                        <p>Bienvenido al laboratorio de ciberseguridad de <strong>Remote Execution</strong>. Este reto está diseñado para poner a prueba tus habilidades en la identificación y explotación de vulnerabilidades de inyección SQL.</p>
                        <p>En este desafío encontrarás un sistema de autenticación vulnerable que simula aplicaciones web del mundo real con fallas de seguridad comunes.</p>
                    </div>
                    <div class="objective-box">
                        <h3><i class="fas fa-target"></i>Objetivo del Reto</h3>
                        <p>Tu misión es obtener acceso como el usuario <strong>'admin'</strong> explotando una vulnerabilidad de <strong>Inyección SQL</strong> en este formulario de login.</p>
                    </div>
                </div>
                <div class="login-panel">
                    <h2><i class="fas fa-shield-alt"></i>Panel de Acceso</h2>
                    <div class="form-group">
                        <?php echo $resultado_login; ?>
                        <a href="index.php" class="login-btn pulse" style="display:block;margin-top:2em;text-align:center;max-width:340px;margin-left:auto;margin-right:auto;">
                            <i class="fas fa-chevron-left"></i> Volver
                        </a>
                    </div>
                    <p class="warning-text">
                        <i class="fas fa-bug"></i> Sistema intencionalmente vulnerable para fines educativos
                    </p>
                </div>
            </section>
            <section class="social-section" id="social">
                <h2><i class="fas fa-users"></i> Únete a la Comunidad</h2>
                <p style="margin-bottom: 2rem; color: #a0a0a0;">Conecta con otros hackers éticos y comparte conocimientos</p>
                <div class="social-links">
                    <a href="https://twitter.com/remoteexecution" class="social-link twitter" target="_blank">
                        <i class="fab fa-twitter"></i>
                        <span>@RemoteExecution</span>
                    </a>
                    <a href="#home" class="social-link github" target="_blank">
                        <i class="fab fa-github"></i>
                        <span>Blog</span>
                    </a>
                    <a href="#home" class="social-link discord" target="_blank">
                        <i class="fab fa-discord"></i>
                        <span>Foro</span>
                    </a>
                    <a href="https://linkedin.com/company/remoteexecution" class="social-link linkedin" target="_blank">
                        <i class="fab fa-linkedin"></i>
                        <span>LinkedIn</span>
                    </a>
                </div>
            </section>
        </div>
    </main>
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-info">
                <div class="footer-section">
                    <h3><i class="fas fa-info-circle"></i> Acerca de</h3>
                    <p>Remote Execution es una comunidad y una plataforma educativa dedicada a la enseñanza de ciberseguridad a través de retos prácticos y desafíos del mundo real.</p>
                </div>
                <div class="footer-section">
                    <h3><i class="fas fa-envelope"></i> Contacto</h3>
                    <p>Email: <a href="mailto:info@remoteexecution.org">info@remoteexecution.org</a></p>
                    <p>Web: <a href="https://remoteexecution.org">remoteexecution.org</a></p>
                </div>
                <div class="footer-section">
                    <h3><i class="fas fa-shield-alt"></i> Seguridad</h3>
                    <p>Todos los retos son realizados en entornos controlados y seguros. El uso de estas técnicas fuera de este contexto educativo puede ser ilegal.</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Remote Execution. Desarrollado por <strong><a href="mailto:juanotejeda@gmail.com">Juano.exe</a></strong> | Todos los derechos reservados.</p>
                <p style="margin-top: 0.5rem; font-size: 0.9rem;">
                    <i class="fas fa-graduation-cap"></i> Plataforma educativa para el aprendizaje ético de ciberseguridad
                </p>
            </div>
        </div>
    </footer>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                if(this.getAttribute('href') !== '#home'){
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        });
        // Header background opacity on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            const scrolled = window.pageYOffset;
            const opacity = Math.min(scrolled / 100, 1);
            header.style.background = `rgba(24, 24, 24, ${0.95 + opacity * 0.05})`;
        });
        // Add random particles animation
        function createParticle() {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 6 + 's';
            particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
            document.querySelector('.particles').appendChild(particle);
            setTimeout(() => { particle.remove(); }, 6000);
        }
        setInterval(createParticle, 2000);
    </script>
</body>
</html>
