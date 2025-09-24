<?php
namespace Quarkphp\Helpers;

/* Helper para panel de depuración en modo desarrollo */

class Debug {
    public static function render($debugData) {
        if (!defined('APP_ENV') || APP_ENV !== 'development') {
            return '';
        }

        // Obtener información adicional del sistema
        $additionalData = [
            'current_route' => $_SERVER['REQUEST_URI'] ?? '/',
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'client_ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'server_time' => date('Y-m-d H:i:s'),
            'php_version' => PHP_VERSION,
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'memory_peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB',
            'execution_time' => isset($_SERVER['REQUEST_TIME_FLOAT']) ? 
                round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 2) . ' ms' : 'N/A',
            'loaded_files' => count(get_included_files()),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'
        ];

        ob_start();
        ?>
        <style>
            /* Debug Toolbar Styles */
            #quarkphp-debug-toolbar * {
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            #quarkphp-debug-icon {
                position: fixed;
                bottom: 25px;
                right: 25px;
                background: linear-gradient(135deg, #ffffffff, #ffe0e0ff);
                color: white;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 10000;
                box-shadow: 0 4px 20px rgba(220, 38, 38, 0.4);
                transition: all 0.3s ease;
                font-size: 25px;
                border: none;
                user-select: none;
            }

            #quarkphp-debug-icon:hover {
                transform: scale(1.1);
                box-shadow: 0 6px 25px rgba(220, 38, 38, 0.5);
            }

            #quarkphp-debug-panel {
                position: fixed;
                bottom: 80px;
                right: 20px;
                background: #ffffff;
                border: 1px solid #e5e5e5;
                border-radius: 15px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
                z-index: 9999;
                width: 750px;
                max-height: 80vh;
                display: none;
                overflow: hidden;
                backdrop-filter: blur(10px);
                animation: slideIn 0.3s ease-out;
            }

            #quarkphp-debug-panel.visible {
                display: block;
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            .debug-header {
                background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
                color: white;
                padding: 12px 16px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            .debug-title {
                font-size: 25px;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .debug-logo {
                width: 20px;
                height: 20px;
                background: #dc2626;
                border-radius: 4px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 18px;
                font-weight: bold;
            }

            .debug-close {
                background: none;
                border: none;
                color: white;
                cursor: pointer;
                padding: 4px 8px;
                border-radius: 4px;
                transition: background-color 0.2s;
                font-size: 25px;
            }

            .debug-close:hover {
                background: rgba(255, 255, 255, 0.1);
            }

            .debug-content {
                max-height: calc(80vh - 50px);
                overflow-y: auto;
            }

            .debug-content::-webkit-scrollbar {
                width: 6px;
            }

            .debug-content::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .debug-content::-webkit-scrollbar-thumb {
                background: #dc2626;
                border-radius: 3px;
            }

            .debug-tabs {
                display: flex;
                background: #f8f9fa;
                border-bottom: 1px solid #e5e5e5;
                overflow-x: auto;
            }

            .debug-tab {
                background: none;
                border: none;
                padding: 12px 16px;
                cursor: pointer;
                font-size: 17px;
                font-weight: 500;
                color: #666666;
                transition: all 0.2s;
                white-space: nowrap;
                border-bottom: 2px solid transparent;
            }

            .debug-tab:hover {
                color: #1a1a1a;
                background: #ffffff;
            }

            .debug-tab.active {
                color: #dc2626;
                background: #ffffff;
                border-bottom-color: #dc2626;
            }

            .debug-tab-content {
                display: none;
                padding: 16px;
            }

            .debug-tab-content.active {
                display: block;
            }

            .debug-section {
                margin-bottom: 20px;
            }

            .debug-section-title {
                font-size: 18px;
                font-weight: 600;
                color: #1a1a1a;
                margin-bottom: 8px;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .debug-item {
                background: #f8f9fa;
                border: 1px solid #e5e5e5;
                border-radius: 6px;
                padding: 10px 14px;
                margin-bottom: 6px;
                font-size: 17px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .debug-item-label {
                color: #666666;
                font-weight: 500;
            }

            .debug-item-value {
                color: #1a1a1a;
                font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
                background: #ffffff;
                padding: 4px 8px;
                border-radius: 3px;
                border: 1px solid #e5e5e5;
                word-break: break-all;
                max-width: 60%;
                text-align: right;
            }

            .debug-code {
                background: #ffffffff;
                color: #000000ff;
                padding: 16px;
                border-radius: 15px;
                font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
                font-size: 17px;
                line-height: 1.5;
                overflow-x: auto;
                white-space: pre-wrap;
                word-break: break-all;
                max-height: 300px;
                overflow-y: auto;
                border: 1px solid #374151;
            }

            .debug-code::-webkit-scrollbar {
                width: 4px;
                height: 4px;
            }

            .debug-code::-webkit-scrollbar-thumb {
                background: #6b7280;
                border-radius: 2px;
            }

            .debug-stats {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                margin-bottom: 16px;
            }

            .debug-stat {
                background: #f8f9fa;
                border: 1px solid #e5e5e5;
                border-radius: 6px;
                padding: 8px;
                text-align: center;
            }

            .debug-stat-value {
                font-size: 20px;
                font-weight: 600;
                color: #dc2626;
                margin-bottom: 2px;
            }

            .debug-stat-label {
                font-size: 10px;
                color: #666666;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .debug-empty {
                text-align: center;
                color: #999999;
                font-style: italic;
                padding: 20px;
                font-size: 13px;
            }

            .debug-badge {
                background: #dc2626;
                color: white;
                padding: 2px 6px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 500;
                margin-left: 8px;
            }

            .debug-copy-btn {
                background: none;
                border: 1px solid #e5e5e5;
                color: #666666;
                padding: 4px 8px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 10px;
                transition: all 0.2s;
                margin-left: 8px;
            }

            .debug-copy-btn:hover {
                border-color: #dc2626;
                color: #dc2626;
            }

            @media (max-width: 480px) {
                #quarkphp-debug-panel {
                    width: calc(100vw - 40px);
                    right: 20px;
                    left: 20px;
                }
            }
        </style>

        <div id="quarkphp-debug-toolbar">
            <!-- Icono flotante -->
            <button id="quarkphp-debug-icon" onclick="toggleDebugPanel()">
                <img style="width: 40px;" src="<?= BASE_URL ?>assets/quarkphp/icon.png" alt="QuarkPHP">
            </button>

            <!-- Panel de debug -->
            <div id="quarkphp-debug-panel">
                <div class="debug-header">
                    <div class="debug-title">
                        <div class="debug-logo">Q</div>
                        QuarkPHP Debug
                        <span class="debug-badge">DEV</span>
                    </div>
                    <button class="debug-close" onclick="toggleDebugPanel()">&times;</button>
                </div>

                <div class="debug-tabs">
                    <button class="debug-tab active" onclick="switchTab('overview')">Resumen</button>
                    <button class="debug-tab" onclick="switchTab('request')">Petición</button>
                    <button class="debug-tab" onclick="switchTab('view')">Vista</button>
                    <button class="debug-tab" onclick="switchTab('session')">Sesión</button>
                    <button class="debug-tab" onclick="switchTab('system')">Sistema</button>
                </div>

                <div class="debug-content">
                    <!-- Tab Overview -->
                    <div id="tab-overview" class="debug-tab-content active">
                        <div class="debug-stats">
                            <div class="debug-stat">
                                <div class="debug-stat-value"><?php echo $additionalData['execution_time']; ?></div>
                                <div class="debug-stat-label">Tiempo Respuesta</div>
                            </div>
                            <div class="debug-stat">
                                <div class="debug-stat-value"><?php echo $additionalData['memory_usage']; ?></div>
                                <div class="debug-stat-label">Memoria Usada</div>
                            </div>
                            <div class="debug-stat">
                                <div class="debug-stat-value"><?php echo $additionalData['loaded_files']; ?></div>
                                <div class="debug-stat-label">Archivos Cargados</div>
                            </div>
                            <div class="debug-stat">
                                <div class="debug-stat-value"><?php echo $additionalData['php_version']; ?></div>
                                <div class="debug-stat-label">Versión PHP</div>
                            </div>
                        </div>

                        <div class="debug-section">
                            <div class="debug-section-title">📍 Ruta Actual</div>
                            <div class="debug-item">
                                <span class="debug-item-label">URL</span>
                                <span class="debug-item-value"><?php echo htmlspecialchars($additionalData['current_route']); ?></span>
                            </div>
                            <div class="debug-item">
                                <span class="debug-item-label">Método</span>
                                <span class="debug-item-value"><?php echo $additionalData['request_method']; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Request -->
                    <div id="tab-request" class="debug-tab-content">
                        <div class="debug-section">
                            <div class="debug-section-title">🌐 Información del Cliente</div>
                            <div class="debug-item">
                                <span class="debug-item-label">Dirección IP</span>
                                <span class="debug-item-value"><?php echo $additionalData['client_ip']; ?></span>
                            </div>
                            <div class="debug-item">
                                <span class="debug-item-label">Navegador</span>
                                <span class="debug-item-value" title="<?php echo htmlspecialchars($additionalData['user_agent']); ?>">
                                    <?php echo htmlspecialchars(substr($additionalData['user_agent'], 0, 40)) . '...'; ?>
                                </span>
                            </div>
                            <div class="debug-item">
                                <span class="debug-item-label">Hora de Petición</span>
                                <span class="debug-item-value"><?php echo $additionalData['server_time']; ?></span>
                            </div>
                        </div>

                        <div class="debug-section">
                            <div class="debug-section-title">📨 Datos de la Petición</div>
                            <?php if (!empty($_GET)): ?>
                                <div class="debug-item">
                                    <span class="debug-item-label">Parámetros GET</span>
                                    <button class="debug-copy-btn" onclick="copyToClipboard('get-data')">Copiar</button>
                                </div>
                                <div class="debug-code" id="get-data"><?php echo json_encode($_GET, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></div>
                            <?php endif; ?>

                            <?php if (!empty($_POST)): ?>
                                <div class="debug-item">
                                    <span class="debug-item-label">Datos POST</span>
                                    <button class="debug-copy-btn" onclick="copyToClipboard('post-data')">Copiar</button>
                                </div>
                                <div class="debug-code" id="post-data"><?php echo json_encode($_POST, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></div>
                            <?php endif; ?>

                            <?php if (empty($_GET) && empty($_POST)): ?>
                                <div class="debug-empty">No hay datos de petición disponibles</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab View -->
                    <div id="tab-view" class="debug-tab-content">
                        <div class="debug-section">
                            <div class="debug-section-title">🎨 Información de la Vista</div>
                            <div class="debug-item">
                                <span class="debug-item-label">Plantilla</span>
                                <span class="debug-item-value"><?php echo htmlspecialchars($debugData['view'] ?? 'N/A'); ?>.php</span>
                            </div>
                        </div>

                        <div class="debug-section">
                            <div class="debug-section-title">
                                Variables de la Plantilla
                                <button class="debug-copy-btn" onclick="copyToClipboard('view-data')">Copiar</button>
                            </div>
                            <?php if (!empty($debugData['data'])): ?>
                                <div class="debug-code" id="view-data"><?php echo print_r($debugData['data'], true); ?></div>
                            <?php else: ?>
                                <div class="debug-empty">No se pasaron variables a la vista</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab Session -->
                    <div id="tab-session" class="debug-tab-content">
                        <div class="debug-section">
                            <div class="debug-section-title">
                                🔐 Datos de Sesión
                                <button class="debug-copy-btn" onclick="copyToClipboard('session-data')">Copiar</button>
                            </div>
                            <?php if (!empty($debugData['session'])): ?>
                                <div class="debug-code" id="session-data"><?php echo print_r($debugData['session'], true); ?></div>
                            <?php else: ?>
                                <div class="debug-empty">No hay datos de sesión disponibles</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tab System -->
                    <div id="tab-system" class="debug-tab-content">
                        <div class="debug-section">
                            <div class="debug-section-title">💾 Uso de Memoria</div>
                            <div class="debug-item">
                                <span class="debug-item-label">Uso Actual</span>
                                <span class="debug-item-value"><?php echo $additionalData['memory_usage']; ?></span>
                            </div>
                            <div class="debug-item">
                                <span class="debug-item-label">Uso Máximo</span>
                                <span class="debug-item-value"><?php echo $additionalData['memory_peak']; ?></span>
                            </div>
                        </div>

                        <div class="debug-section">
                            <div class="debug-section-title">⚙️ Información del Servidor</div>
                            <div class="debug-item">
                                <span class="debug-item-label">Software del Servidor</span>
                                <span class="debug-item-value"><?php echo htmlspecialchars($additionalData['server_software']); ?></span>
                            </div>
                            <div class="debug-item">
                                <span class="debug-item-label">Versión PHP</span>
                                <span class="debug-item-value"><?php echo $additionalData['php_version']; ?></span>
                            </div>
                            <div class="debug-item">
                                <span class="debug-item-label">Versión QuarkPHP</span>
                                <span class="debug-item-value"><?php echo defined('QUARKPHP_VERSION') ? QUARKPHP_VERSION : 'Desconocida'; ?></span>
                            </div>
                        </div>

                        <div class="debug-section">
                            <div class="debug-section-title">
                                📁 Archivos Incluidos
                                <button class="debug-copy-btn" onclick="copyToClipboard('included-files')">Copiar</button>
                            </div>
                            <div class="debug-code" id="included-files"><?php 
                                /* $files = get_included_files();
                                foreach($files as $index => $file) {
                                    echo ($index + 1) . ". " . $file . "\n";
                                } */
                            ?></div>
                        </div>
                    </div><br>
                </div>
            </div>
        </div>

        <script>
            function toggleDebugPanel() {
                const panel = document.getElementById('quarkphp-debug-panel');
                panel.classList.toggle('visible');
            }

            function switchTab(tabName) {
                // Ocultar todas las pestañas
                const contents = document.querySelectorAll('.debug-tab-content');
                const tabs = document.querySelectorAll('.debug-tab');
                
                contents.forEach(content => content.classList.remove('active'));
                tabs.forEach(tab => tab.classList.remove('active'));
                
                // Mostrar la pestaña seleccionada
                document.getElementById('tab-' + tabName).classList.add('active');
                event.target.classList.add('active');
            }

            function copyToClipboard(elementId) {
                const element = document.getElementById(elementId);
                const text = element.textContent;
                
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(() => {
                        showCopyFeedback(event.target);
                    });
                } else {
                    // Fallback para navegadores antiguos
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    showCopyFeedback(event.target);
                }
            }

            function showCopyFeedback(button) {
                const originalText = button.textContent;
                button.textContent = '¡Copiado!';
                button.style.color = '#16a34a';
                button.style.borderColor = '#16a34a';
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.style.color = '';
                    button.style.borderColor = '';
                }, 1500);
            }

            // Cerrar panel al hacer clic fuera
            document.addEventListener('click', function(event) {
                const panel = document.getElementById('quarkphp-debug-panel');
                const icon = document.getElementById('quarkphp-debug-icon');
                
                if (!panel.contains(event.target) && !icon.contains(event.target) && panel.classList.contains('visible')) {
                    panel.classList.remove('visible');
                }
            });

            // Atajos de teclado
            document.addEventListener('keydown', function(event) {
                // Ctrl + Shift + D para toggle del panel
                if (event.ctrlKey && event.shiftKey && event.key === 'D') {
                    event.preventDefault();
                    toggleDebugPanel();
                }
                
                // Escape para cerrar panel
                if (event.key === 'Escape') {
                    const panel = document.getElementById('quarkphp-debug-panel');
                    if (panel.classList.contains('visible')) {
                        panel.classList.remove('visible');
                    }
                }
            });
        </script>
        <?php
        return ob_get_clean();
    }
}
?>