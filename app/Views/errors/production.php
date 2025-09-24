<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en el Servidor | QuarkPHP</title>
    <link rel="icon" type="image/png" href="public/assets/quarkphp/icon.png">
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            background: rgba(220, 38, 38, 0.03);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 15%;
            animation-delay: 3s;
        }

        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 10%;
            left: 10%;
            animation-delay: 6s;
        }

        .shape:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 20%;
            right: 20%;
            animation-delay: 2s;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.1);
            animation: fadeInScale 0.8s ease-out;
            backdrop-filter: blur(10px);
        }

        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(220, 38, 38, 0.3);
            animation: gentlePulse 3s ease-in-out infinite;
            position: relative;
        }

        .error-icon::before {
            content: '';
            position: absolute;
            width: 130px;
            height: 130px;
            border: 2px solid rgba(220, 38, 38, 0.2);
            border-radius: 50%;
            animation: rippleEffect 2s ease-out infinite;
        }

        .error-icon span {
            font-size: 3rem;
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .error-code {
            font-size: 1.5rem;
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 1rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1a1a1a;
            line-height: 1.2;
        }

        .error-message {
            font-size: 1.2rem;
            color: #666666;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #666666;
            border: 2px solid #e5e5e5;
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            color: #1a1a1a;
            transform: translateY(-3px);
            border-color: rgba(220, 38, 38, 0.3);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .error-details {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            border: 1px solid rgba(220, 38, 38, 0.1);
        }

        .error-details h4 {
            color: #dc2626;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .error-details p {
            color: #666666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .support-info {
            margin-top: 2rem;
            padding: 1rem;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.05), rgba(239, 68, 68, 0.05));
            border-radius: 8px;
            border: 1px solid rgba(220, 38, 38, 0.1);
        }

        .support-info h4 {
            color: #dc2626;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .support-info p {
            color: #666666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes gentlePulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes rippleEffect {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            33% {
                transform: translateY(-15px) rotate(120deg);
            }
            66% {
                transform: translateY(15px) rotate(240deg);
            }
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 2rem;
                margin: 1rem;
            }

            .error-title {
                font-size: 2rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-icon {
                width: 100px;
                height: 100px;
            }

            .error-icon span {
                font-size: 2.5rem;
            }

            .error-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="error-container">
        <div class="error-icon">
            <span>⚠️</span>
        </div>
        
        <div class="error-code">Error 500</div>
        
        <h1 class="error-title">Error en el Servidor</h1>
        
        <p class="error-message">
            Lo sentimos, algo salió mal en nuestros servidores. 
            Nuestro equipo técnico ha sido notificado y está trabajando para resolver el problema.
        </p>

        <div class="error-details">
            <h4>Información del Error</h4>
            <p><strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
            <p><strong>Estado:</strong> En proceso de resolución</p>
        </div>

        <div class="support-info">
            <h4>¿Necesitas ayuda?</h4>
            <p>Si el problema persiste, por favor contacta a nuestro equipo de soporte técnico</p>
        </div>
        
        <div class="error-actions">
            <a href="<?php echo BASE_URL ?? '/'; ?>" class="btn btn-primary">
                <span>🏠</span>
                Volver al Inicio
            </a>
            <button onclick="window.location.reload()" class="btn btn-secondary">
                <span>🔄</span>
                Intentar de Nuevo
            </button>
        </div>
    </div>

    <script>
        // Efecto de partículas al hacer clic
        document.addEventListener('click', function(e) {
            createParticle(e.clientX, e.clientY);
        });

        function createParticle(x, y) {
            const particle = document.createElement('div');
            const colors = ['#dc2626', '#ef4444', '#f87171'];
            const color = colors[Math.floor(Math.random() * colors.length)];
            const size = Math.random() * 6 + 4;
            const randomX = (Math.random() - 0.5) * 100;
            const randomY = (Math.random() - 0.5) * 100;
            
            particle.style.cssText = `
                position: fixed;
                width: ${size}px;
                height: ${size}px;
                background: ${color};
                border-radius: 50%;
                pointer-events: none;
                z-index: 1000;
                left: ${x}px;
                top: ${y}px;
                transform: translate(-50%, -50%);
            `;
            
            document.body.appendChild(particle);
            
            particle.animate([
                {
                    transform: 'translate(-50%, -50%) scale(1)',
                    opacity: 1
                },
                {
                    transform: `translate(calc(-50% + ${randomX}px), calc(-50% + ${randomY}px)) scale(0)`,
                    opacity: 0
                }
            ], {
                duration: 800,
                easing: 'ease-out'
            }).onfinish = () => particle.remove();
        }

        // Animación de entrada para elementos
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.error-container');
            const details = document.querySelector('.error-details');
            const support = document.querySelector('.support-info');
            
            // Animación escalonada
            setTimeout(() => {
                details.style.opacity = '0';
                details.style.transform = 'translateY(20px)';
                details.style.transition = 'all 0.6s ease';
                details.style.opacity = '1';
                details.style.transform = 'translateY(0)';
            }, 300);
            
            setTimeout(() => {
                support.style.opacity = '0';
                support.style.transform = 'translateY(20px)';
                support.style.transition = 'all 0.6s ease';
                support.style.opacity = '1';
                support.style.transform = 'translateY(0)';
            }, 600);

            // Efecto hover mejorado para botones
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px) scale(1.02)';
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });

        // Auto-refresh cada 30 segundos (opcional)
        let autoRefreshEnabled = false;
        
        document.addEventListener('keydown', function(e) {
            // Presionar 'R' para activar auto-refresh
            if (e.key.toLowerCase() === 'r' && e.ctrlKey) {
                e.preventDefault();
                autoRefreshEnabled = !autoRefreshEnabled;
                
                if (autoRefreshEnabled) {
                    console.log('Auto-refresh activado (30s)');
                    setTimeout(() => {
                        if (autoRefreshEnabled) window.location.reload();
                    }, 30000);
                } else {
                    console.log('Auto-refresh desactivado');
                }
            }
        });
    </script>
</body>
</html>