<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuarkPHP v<?= QUARKPHP_VERSION ?> </title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/quarkphp/icon.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            color: #1a1a1a;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Navegación */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(220, 38, 38, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1a1a1a;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .navbar-brand img {
            width: 32px;
            height: 32px;
        }

        .navbar-nav {
            display: flex;
            list-style: none;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: #666666;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: #dc2626;
        }

        .nav-link.active {
            color: #dc2626;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #dc2626;
            transition: width 0.3s ease;
        }

        .nav-link:hover:after,
        .nav-link.active:after {
            width: 100%;
        }

        /* Layout principal */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
            min-height: calc(100vh - 120px);
        }

        /* Sidebar */
        .sidebar {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            padding: 1.5rem;
            height: fit-content;
            border: 1px solid rgba(220, 38, 38, 0.1);
            backdrop-filter: blur(10px);
        }

        .sidebar h3 {
            color: #dc2626;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            color: #666666;
            text-decoration: none;
            padding: 0.5rem 1rem;
            display: block;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .sidebar-menu a:hover {
            background: rgba(220, 38, 38, 0.05);
            color: #dc2626;
            transform: translateX(5px);
        }

        /* Contenido principal */
        .main-content {
            background: rgba(248, 250, 252, 0.5);
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid rgba(220, 38, 38, 0.1);
            backdrop-filter: blur(10px);
        }

        .hero-section {
            text-align: center;
            margin-bottom: 3rem;
        }

        .logo-container {
            margin-bottom: 2rem;
            animation: logoFloat 3s ease-in-out infinite;
        }

        .logo-container img {
            width: 300px;
            height: auto;
            max-width: 100%;
            filter: drop-shadow(0 10px 20px rgba(220, 38, 38, 0.3));
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #dc2626, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: #666666;
            margin-bottom: 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid rgba(220, 38, 38, 0.1);
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(220, 38, 38, 0.3);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.1);
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            display: block;
        }

        .feature-title {
            color: #dc2626;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-description {
            color: #666666;
            font-size: 0.9rem;
        }

        .stats-section {
            background: rgba(220, 38, 38, 0.05);
            border-radius: 8px;
            padding: 2rem;
            margin: 2rem 0;
            border: 1px solid rgba(220, 38, 38, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            text-align: center;
        }

        .stat-item h4 {
            font-size: 2rem;
            color: #dc2626;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: #666666;
            font-size: 0.9rem;
        }

        .cta-section {
            text-align: center;
            margin-top: 3rem;
            padding: 2rem;
            background: rgba(220, 38, 38, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(220, 38, 38, 0.1);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(45deg, #dc2626, #ef4444);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            margin: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #dc2626;
            color: #dc2626;
        }

        .btn-outline:hover {
            background: #dc2626;
            color: white;
        }

        /* Animaciones */
        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive */
        @media (max-width: 968px) {
            .main-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .navbar-container {
                padding: 0 1rem;
            }

            .navbar-nav {
                gap: 1rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .logo-container img {
                width: 250px;
            }
        }

        @media (max-width: 640px) {
            .main-container {
                padding: 1rem;
            }

            .main-content,
            .sidebar {
                padding: 1rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .navbar-nav {
                display: none;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/templates/nav.php'; ?>

    <div class="main-container">
        <?php include __DIR__ . '/templates/side.php'; ?>

        <!-- Contenido Principal -->
        <main class="main-content">
            <section class="hero-section">
                <div class="logo-container">
                    <img src="<?= BASE_URL ?>assets/quarkphp/icon.png" alt="QuarkPHP Logo">
                </div>
                <h1 class="hero-title">Bienvenido a QuarkPHP v<?= QUARKPHP_VERSION ?></h1>
                <p class="hero-subtitle">El framework PHP ultraligero y potente para desarrollo ágil</p>
            </section>

            <section class="stats-section">
                <div class="stats-grid">
                    <div class="stat-item">
                        <h4>&lt; 1MB</h4>
                        <p>Tamaño del Core</p>
                    </div>
                    <div class="stat-item">
                        <h4>Rápido</h4>
                        <p>Alto Rendimiento</p>
                    </div>
                    <div class="stat-item">
                        <h4>Simple</h4>
                        <p>Fácil de Usar</p>
                    </div>
                    <div class="stat-item">
                        <h4>Modular</h4>
                        <p>Arquitectura MVC</p>
                    </div>
                </div>
            </section>

            <div class="features-grid">
                <div class="feature-card">
                    <span class="feature-icon">⚡</span>
                    <h3 class="feature-title">Ultra Ligero</h3>
                    <p class="feature-description">Framework minimalista con el core esencial para desarrollo rápido y eficiente.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">🏗️</span>
                    <h3 class="feature-title">Arquitectura MVC</h3>
                    <p class="feature-description">Estructura organizada que separa lógica, presentación y datos de forma clara.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">🎯</span>
                    <h3 class="feature-title">Routing Inteligente</h3>
                    <p class="feature-description">Sistema de rutas flexible y potente para manejar URLs de forma elegante.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">📊</span>
                    <h3 class="feature-title">Controladores Dinámicos</h3>
                    <p class="feature-description">Gestión intuitiva de la lógica de aplicación con controladores fáciles de crear.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">👁️</span>
                    <h3 class="feature-title">Sistema de Vistas</h3>
                    <p class="feature-description">Templates y vistas con sintaxis PHP nativa para máxima flexibilidad.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">🔧</span>
                    <h3 class="feature-title">Configuración Simple</h3>
                    <p class="feature-description">Setup mínimo con configuraciones claras y documentadas para empezar rápido.</p>
                </div>
            </div>

            <section class="cta-section">
                <h2>Documentacion</h2>
                <p>QuarkPHP permite crear aplicaciones web sencillas con una curva de aprendizaje mínima.</p>
                <div style="margin-top: 1.5rem;">
                    <a href="#" class="btn">Empezar Ahora</a>
                    <a href="#" class="btn btn-outline">Ver Documentación</a>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Efectos interactivos
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto parallax suave para el logo
            const logo = document.querySelector('.logo-container img');
            let mouseX = 0;
            let mouseY = 0;

            document.addEventListener('mousemove', function(e) {
                mouseX = (e.clientX / window.innerWidth) * 100;
                mouseY = (e.clientY / window.innerHeight) * 100;
                
                logo.style.transform = `translate(${(mouseX - 50) * 0.1}px, ${(mouseY - 50) * 0.1}px)`;
            });

            // Animación de entrada para las tarjetas
            const cards = document.querySelectorAll('.feature-card');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const cardObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '0';
                        entry.target.style.transform = 'translateY(30px)';
                        entry.target.style.transition = 'all 0.6s ease';
                        
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, 100);
                    }
                });
            }, observerOptions);

            cards.forEach(card => {
                cardObserver.observe(card);
            });

            // Efectos de hover mejorados para navegación
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.textShadow = '0 0 10px rgba(220, 38, 38, 0.5)';
                });
                
                link.addEventListener('mouseleave', function() {
                    this.style.textShadow = 'none';
                });
            });
        });

        // Easter egg: Konami Code
        let konamiCode = [];
        const konamiSequence = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];

        document.addEventListener('keydown', function(e) {
            konamiCode.push(e.keyCode);
            konamiCode = konamiCode.slice(-10);
            
            if (konamiCode.join('') === konamiSequence.join('')) {
                document.body.style.animation = 'rainbow 2s ease-in-out';
                setTimeout(() => {
                    document.body.style.animation = '';
                }, 2000);
            }
        });

        // Añadir animación rainbow
        const style = document.createElement('style');
        style.textContent = `
            @keyframes rainbow {
                0% { filter: hue-rotate(0deg); }
                25% { filter: hue-rotate(90deg); }
                50% { filter: hue-rotate(180deg); }
                75% { filter: hue-rotate(270deg); }
                100% { filter: hue-rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>