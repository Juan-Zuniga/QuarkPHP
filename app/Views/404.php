<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página No Encontrada | QuarkPHP</title>
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
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
            animation: fadeInUp 0.8s ease-out;
        }

        .error-icon {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            background: linear-gradient(45deg, #dc2626, #ef4444);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        .error-icon img {
            width: 80px;
            height: 80px;
            filter: brightness(0) invert(1);
        }

        .error-code {
            font-size: 6rem;
            font-weight: 900;
            color: #dc2626;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            line-height: 1;
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1a1a1a;
        }

        .error-message {
            font-size: 1.2rem;
            color: #666666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #dc2626, #ef4444);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: #666666;
            border: 2px solid #e5e5e5;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
            color: #1a1a1a;
            transform: translateY(-2px);
            border-color: #dc2626;
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
            background: rgba(220, 38, 38, 0.05);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 40px;
            height: 40px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes particleExplosion {
            0% {
                transform: scale(1) translate(0, 0);
                opacity: 1;
            }
            100% {
                transform: scale(0);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 4rem;
            }
            
            .error-title {
                font-size: 2rem;
            }
            
            .error-message {
                font-size: 1rem;
            }
            
            .error-container {
                padding: 1rem;
            }
            
            .error-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="error-container">
        <div class="error-icon">
            <img src="<?= BASE_URL ?>assets/quarkphp/icon.png" alt="QuarkPHP Icon">
        </div>
        
        <div class="error-code">404</div>
        
        <h1 class="error-title">Página No Encontrada</h1>
        
        <p class="error-message">
            La página que buscas no existe o ha sido movida. 
            <br>Verifica la URL o regresa al inicio para continuar navegando.
        </p>
        
        <div class="error-actions">
            <a href="/" class="btn btn-primary">
                <span></span>
                Ir al Inicio
            </a>
            <button onclick="history.back()" class="btn btn-secondary">
                <span>←</span>
                Volver Atrás
            </button>
        </div>
    </div>

    <script>
        // Animación adicional para el ícono
        document.addEventListener('DOMContentLoaded', function() {
            const errorIcon = document.querySelector('.error-icon');
            
            errorIcon.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) rotate(5deg)';
            });
            
            errorIcon.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) rotate(0deg)';
            });
        });

        // Efectos de partículas al hacer clic
        document.addEventListener('click', function(e) {
            createParticle(e.clientX, e.clientY);
        });

        function createParticle(x, y) {
            const particle = document.createElement('div');
            const randomX = (Math.random() - 0.5) * 100;
            const randomY = (Math.random() - 0.5) * 100;
            
            particle.style.cssText = `
                position: fixed;
                width: 6px;
                height: 6px;
                background: #dc2626;
                border-radius: 50%;
                pointer-events: none;
                z-index: 1000;
                left: ${x}px;
                top: ${y}px;
                transform: translate(-50%, -50%);
                animation: particleExplosion 0.6s ease-out forwards;
            `;
            
            // Añadir keyframe personalizado para esta partícula
            const keyframes = `
                @keyframes particleExplosion-${Date.now()} {
                    0% {
                        transform: translate(-50%, -50%) scale(1);
                        opacity: 1;
                    }
                    100% {
                        transform: translate(calc(-50% + ${randomX}px), calc(-50% + ${randomY}px)) scale(0);
                        opacity: 0;
                    }
                }
            `;
            
            const style = document.createElement('style');
            style.textContent = keyframes;
            document.head.appendChild(style);
            
            particle.style.animation = `particleExplosion-${Date.now()} 0.6s ease-out forwards`;
            
            document.body.appendChild(particle);
            
            setTimeout(() => {
                particle.remove();
                style.remove();
            }, 600);
        }
    </script>
</body>
</html>