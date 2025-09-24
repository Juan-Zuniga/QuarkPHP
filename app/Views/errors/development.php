<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en Desarrollo | QuarkPHP</title>
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
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Navegación superior */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .error-badge {
            background: #dc2626;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: auto;
        }

        /* Contenido principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .error-header {
            background: #fafafa;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .error-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .error-subtitle {
            font-size: 1rem;
            color: #666666;
        }

        .error-section {
            background: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .section-header {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e5e5;
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .section-content {
            padding: 1.5rem;
        }

        /* Mensaje de error */
        .error-message {
            background: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 1rem 1.5rem;
            font-size: 2rem;
            font-weight: 500;
            color: #7f1d1d;
        }

        /* Información del archivo */
        .file-info {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 1rem;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9rem;
        }

        .file-path {
            color: #1a1a1a;
            font-weight: 600;
            word-break: break-all;
        }

        .line-number {
            background: #dc2626;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-left: 0.5rem;
            display: inline-block;
        }

        /* Stack trace mejorado */
        .stack-trace-container {
            position: relative;
        }

        .stack-trace-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .copy-button {
            background: #f8f9fa;
            border: 1px solid #d1d5db;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .copy-button:hover {
            background: #e5e7eb;
            border-color: #9ca3af;
        }

        .copy-button.copied {
            background: #dcfce7;
            border-color: #16a34a;
            color: #166534;
        }

        .stack-trace {
            background: #1a1a1a;
            color: #f5f5f5;
            padding: 1.5rem;
            border-radius: 6px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.85rem;
            line-height: 1.5;
            overflow-x: auto;
            white-space: pre;
            border: 1px solid #374151;
            max-height: 400px;
            overflow-y: auto;
        }

        .stack-trace::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .stack-trace::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 4px;
        }

        .stack-trace::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 4px;
        }

        .stack-trace::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .stack-trace::-webkit-scrollbar-corner {
            background: #374151;
        }

        /* Highlight para elementos importantes del stack trace */
        .stack-trace .highlight-file {
            color: #fbbf24;
            font-weight: 600;
        }

        .stack-trace .highlight-line {
            color: #dc2626;
            font-weight: 600;
        }

        .stack-trace .highlight-function {
            color: #60a5fa;
        }

        .stack-trace .highlight-class {
            color: #a78bfa;
        }

        /* Información de debug */
        .debug-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .debug-item {
            background: #f8f9fa;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 1rem;
            text-align: center;
        }

        .debug-label {
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .debug-value {
            font-size: 0.9rem;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            color: #1a1a1a;
            font-weight: 600;
        }

        /* Acciones */
        .actions {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e5e5;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            margin: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            background: #ffffff;
            color: #374151;
        }

        .btn:hover {
            background: #f9fafb;
            border-color: #9ca3af;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .btn-primary:hover {
            background: #b91c1c;
            border-color: #b91c1c;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .navbar-container {
                padding: 0 1rem;
            }

            .error-header,
            .section-content {
                padding: 1rem;
            }

            .debug-grid {
                grid-template-columns: 1fr;
            }

            .stack-trace {
                font-size: 0.8rem;
                padding: 1rem;
            }

            .stack-trace-header {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
            }
        }

        /* Animaciones sutiles */
        .error-section {
            animation: fadeInUp 0.3s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?= BASE_URL ?>" class="navbar-brand">
                <img src="<?= BASE_URL ?>assets/quarkphp/icon.png" alt="QuarkPHP">
                QuarkPHP
            </a>
            <div class="error-badge">Error en Desarrollo</div>
        </div>
    </nav>

    <div class="container">
        <!-- Mensaje de error -->
        <div class="section-content">
            <div class="error-message">
                <?php echo htmlspecialchars($exception->getMessage()); ?>
            </div>
        </div><br>

        <!-- Ubicación del error -->
        <div class="error-section">
            <div class="section-header">Ubicación del Error</div>
            <div class="section-content">
                <div class="file-info">
                    <div class="file-path"><?php echo htmlspecialchars($exception->getFile()); ?>   --->  <span class="line-number">Línea <?php echo $exception->getLine(); ?></span></div>
                </div>
            </div>
        </div>

        <!-- Información de debug -->
        <div class="error-section">
            <div class="section-header">Información de Debug</div>
            <div class="section-content">
                <div class="debug-grid">
                    <div class="debug-item">
                        <div class="debug-label">Tipo de Excepción</div>
                        <div class="debug-value"><?php echo get_class($exception); ?></div>
                    </div>
                    <div class="debug-item">
                        <div class="debug-label">Código de Error</div>
                        <div class="debug-value"><?php echo $exception->getCode() ?: 'N/A'; ?></div>
                    </div>
                    <div class="debug-item">
                        <div class="debug-label">Timestamp</div>
                        <div class="debug-value"><?php echo date('Y-m-d H:i:s'); ?></div>
                    </div>
                    <div class="debug-item">
                        <div class="debug-label">Memoria Usada</div>
                        <div class="debug-value"><?php echo round(memory_get_usage(true) / 1024 / 1024, 2); ?> MB</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stack trace -->
        <div class="error-section">
            <div class="section-header">Stack Trace</div>
            <div class="section-content">
                <div class="stack-trace-container">
                    <div class="stack-trace-header">
                        <span style="font-size: 0.9rem; color: #6b7280;">Traza completa de la ejecución</span>
                        <button class="copy-button" onclick="copyStackTrace()">Copiar al Portapapeles</button>
                    </div>
                    <div class="stack-trace" id="stackTrace"><?php echo htmlspecialchars($exception->getTraceAsString()); ?></div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="actions">
            <a href="<?php echo BASE_URL ?? '/'; ?>" class="btn btn-primary">Volver al Inicio</a>
            <button onclick="window.location.reload()" class="btn">Recargar Página</button>
        </div>
    </div>

    <script>
        // Función para copiar stack trace
        function copyStackTrace() {
            const stackTrace = document.getElementById('stackTrace');
            const button = document.querySelector('.copy-button');
            
            navigator.clipboard.writeText(stackTrace.textContent).then(() => {
                const originalText = button.textContent;
                button.textContent = 'Copiado!';
                button.classList.add('copied');
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('copied');
                }, 2000);
            }).catch(() => {
                // Fallback para navegadores que no soportan clipboard API
                const textArea = document.createElement('textarea');
                textArea.value = stackTrace.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                const originalText = button.textContent;
                button.textContent = 'Copiado!';
                button.classList.add('copied');
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('copied');
                }, 2000);
            });
        }

        // Highlight de sintaxis básico para el stack trace
        document.addEventListener('DOMContentLoaded', function() {
            const stackTrace = document.getElementById('stackTrace');
            let content = stackTrace.innerHTML;
            
            // Destacar archivos PHP
            content = content.replace(/([\/\w\-\.]+\.php)/g, '<span class="highlight-file">$1</span>');
            
            // Destacar números de línea
            content = content.replace(/:(\d+)/g, ':<span class="highlight-line">$1</span>');
            
            // Destacar funciones y métodos
            content = content.replace(/(\w+::\w+|\w+\(\))/g, '<span class="highlight-function">$1</span>');
            
            // Destacar clases
            content = content.replace(/([A-Z]\w+\\[A-Z]\w+)/g, '<span class="highlight-class">$1</span>');
            
            stackTrace.innerHTML = content;
        });

        // Animación de entrada escalonada
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.error-section');
            sections.forEach((section, index) => {
                section.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>