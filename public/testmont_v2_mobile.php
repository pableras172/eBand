<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calculadora de Troquel - Sistema Modular</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            padding: 15px;
        }

        @media (min-width: 768px) {
            body {
                padding: 30px;
            }
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 768px) {
            .main-container {
                padding: 30px;
            }
        }

        h2 {
            color: #333;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
            font-size: 1.5rem;
        }

        @media (min-width: 768px) {
            h2 {
                font-size: 2rem;
            }
        }

        h3 {
            color: #666;
            margin-top: 20px;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        @media (min-width: 768px) {
            h3 {
                font-size: 1.3rem;
            }
        }

        .preview-box {
            width: 100%;
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 90px;
            text-align: center;
            background: #fafafa;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .fibra-control {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #4CAF50;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 0.75rem;
            font-weight: bold;
            color: #2e7d32;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .fibra-control.top {
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            flex-direction: row;
        }

        .fibra-control.right {
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            flex-direction: column;
            /*writing-mode: vertical-lr;*/
        }
        
        /* Overlay de líneas de fibra */
        .fibra-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 5;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .fibra-overlay.visible {
            opacity: 0.4;
        }
        
        .fibra-overlay.horizontal {
            background-image: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 8px,
                rgba(76, 175, 80, 0.6) 8px,
                rgba(76, 175, 80, 0.6) 10px
            );
        }
        
        .fibra-overlay.vertical {
            background-image: repeating-linear-gradient(
                90deg,
                transparent,
                transparent 8px,
                rgba(76, 175, 80, 0.6) 8px,
                rgba(76, 175, 80, 0.6) 10px
            );
        }

        .fibra-arrow {
            /*cursor: pointer;*/
            font-size: 1.2rem;
            padding: 4px 8px;
            background: #e8f5e9;
            border-radius: 4px;
            transition: all 0.2s;
            user-select: none;
        }

        /*.fibra-arrow:hover {
            background: #4CAF50;
            color: white;
            transform: scale(1.1);
        }

        .fibra-arrow.active {
            background: #4CAF50;
            color: white;
        }

        .fibra-label {
            white-space: nowrap;
            font-size: 0.7rem;
        }*/

        @media (min-width: 768px) {
            .fibra-control {
                font-size: 0.85rem;
                padding: 10px 15px;
            }

            .fibra-arrow {
                font-size: 1.4rem;
            }

            .fibra-label {
                font-size: 0.8rem;
            }
        }

        @media (min-width: 768px) {
            .preview-box {
                padding: 90px;
                min-height: 400px;
            }
        }

        .preview-box.has-image {
            border-color: #4CAF50;
            background: #f1f8f4;
        }

        .preview-box img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 768px) {
            .preview-box img {
                max-height: 500px;
            }
        }

        .preview-placeholder {
            color: #999;
            font-size: 14px;
        }

        .medida-row {
            margin-bottom: 12px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
        }

        @media (min-width: 768px) {
            .medida-row {
                padding: 12px;
            }
        }

        .medida-label {
            font-weight: bold;
            color: #4CAF50;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        @media (min-width: 768px) {
            .medida-label {
                font-size: 1.1rem;
                margin-bottom: 0;
            }
        }

        .totales-box {
            background: #e8f5e9;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }

        @media (min-width: 768px) {
            .totales-box {
                padding: 20px;
                margin: 20px 0;
            }
        }

        .total-item {
            text-align: center;
            margin-bottom: 15px;
        }

        @media (min-width: 768px) {
            .total-item {
                margin-bottom: 0;
            }
        }

        .total-label {
            font-weight: bold;
            color: #2e7d32;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        @media (min-width: 768px) {
            .total-label {
                font-size: 1rem;
            }
        }

        .total-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1b5e20;
        }

        @media (min-width: 768px) {
            .total-value {
                font-size: 2rem;
            }
        }

        .total-unit {
            font-size: 1rem;
            color: #666;
        }

        @media (min-width: 768px) {
            .total-unit {
                font-size: 1.2rem;
            }
        }

        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 12px;
            margin: 15px 0;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        @media (min-width: 768px) {
            .info-box {
                margin: 20px 0;
                font-size: 0.95rem;
            }
        }

        .info-box strong {
            color: #1976D2;
        }

        .resultado {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
        }

        @media (min-width: 768px) {
            .resultado {
                margin-top: 30px;
                padding: 20px;
            }
        }

        .resultado img {
            /*max-width: 100%;*/
            border: 2px solid #4CAF50;
            border-radius: 4px;
        }

        .info-card {
            background: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        @media (min-width: 768px) {
            .info-card {
                padding: 15px;
            }
        }

        .slider-container {
            background: #fff3e0;
            border: 2px solid #FF9800;
            border-radius: 8px;
            padding: 12px;
            margin: 15px 0;
        }

        @media (min-width: 768px) {
            .slider-container {
                padding: 15px;
                margin: 20px 0;
            }
        }
    </style>
</head>

<body>

    <div class="main-container">
        <h2 class="text-center mb-4">🧩 Calculadora de Troquel - Sistema Modular A-B-C-D-E</h2>

        <div class="alert alert-info" role="alert">
            <strong>ℹ️ Instrucciones:</strong><br>
            1. Sube la imagen PNG de la caja<br>
            2. Introduce las medidas de cada parte (A, B, C, D, E)<br>
            3. Indica si cada medida es Ancho o Alto<br>
            4. Los totales se calcularán automáticamente
        </div>

        <form method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label fw-bold">🖼️ Imagen PNG de la caja completa</label>

            </div>



            <div class="row g-3">

                <!-- Columna izquierda: Medidas -->
                <div class="col-12 col-lg-6">
                    <h3>📏 Medidas de las partes del troquel</h3>

                    <!-- Alto = A + (Cx2) +  (Dx2) -->
                    <!-- Ancho = (Bx2) + (Cx2) + (E) -->
                    <div class="medida-row">
                        <div class="medida-label">A (Alto)</div>
                        <input type="number" class="form-control" step="0.1" name="ancho_a" id="ancho_a" min="0" placeholder="cm" value="<?php echo isset($_POST['ancho_a']) ? htmlspecialchars($_POST['ancho_a']) : '7.6' ?>">
                    </div>

                    <div class="medida-row">
                        <div class="medida-label">B (Ancho)</div>
                        <input type="number" class="form-control" step="0.1" name="ancho_b" id="ancho_b" min="0" placeholder="cm" value="<?php echo isset($_POST['ancho_b']) ? htmlspecialchars($_POST['ancho_b']) : '10' ?>">
                    </div>

                    <div class="medida-row">
                        <div class="medida-label">C (Ancho y Alto)</div>
                        <input type="number" class="form-control" step="0.1" name="ancho_c" id="ancho_c" min="0" placeholder="cm" value="<?php echo isset($_POST['ancho_c']) ? htmlspecialchars($_POST['ancho_c']) : '5.8' ?>">
                    </div>

                    <div class="medida-row">
                        <div class="medida-label">D (alto)</div>
                        <input type="number" class="form-control" step="0.1" name="ancho_d" id="ancho_d" min="0" placeholder="cm" value="<?php echo isset($_POST['ancho_d']) ? htmlspecialchars($_POST['ancho_d']) : '1.8' ?>">
                    </div>

                    <div class="medida-row">
                        <div class="medida-label">E (ancho)</div>
                        <input type="number" class="form-control" step="0.1" name="ancho_e" id="ancho_e" min="0" placeholder="cm" value="<?php echo isset($_POST['ancho_e']) ? htmlspecialchars($_POST['ancho_e']) : '1.5' ?>">
                    </div>



                </div>

                <!-- Columna derecha: Preview de imagen -->
                <div class="col-12 col-lg-6">
                    <h4 class="text-muted mb-3">🖼️ Vista previa</h4>
                    <div class="preview-box" id="preview-box">
                        <div class="preview-placeholder">La imagen aparecerá aquí al subirla</div>
                        
                        <!-- Overlay de líneas de fibra -->
                        <div class="fibra-overlay" id="fibra_overlay"></div>
                        
                        <!-- Control de fibra horizontal (superior) -->
                        <div class="fibra-control top">
                            <span class="fibra-arrow" data-direction="left" title="Fibra hacia la izquierda">←</span>
                            <input class="form-check-input" type="radio" name="direccion_fibra_caja" id="fibra_caja_horizontal" value="horizontal" > 
                            <span class="fibra-label">Fibra</span>
                            <span class="fibra-arrow" data-direction="right" title="Fibra hacia la derecha">→</span>
                        </div>
                        
                        <!-- Control de fibra vertical (lateral derecho) -->
                        <div class="fibra-control right">
                            <span class="fibra-arrow" data-direction="up" title="Fibra hacia arriba">↑</span>
                            <input class="form-check-input" type="radio" name="direccion_fibra_caja" id="fibra_caja_vertical" value="vertical" > 
                            <span class="fibra-label">Fibra</span>
                            <span class="fibra-arrow" data-direction="down" title="Fibra hacia abajo">↓</span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-2">
                        <div style="display: none;">
                            <input type="file" class="form-control" name="imagen" accept="image/png" id="imagen">
                        </div>
                        <small id="dimensiones" style="display: none;" class="form-text text-muted"></small>

                    </div>

                </div>
            </div>

            <div class="totales-box mt-3">
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <div class="total-item">
                            <div class="total-label">📐 ANCHO TOTAL</div>
                            <div class="total-value"><span id="ancho_total">0</span> <span class="total-unit">cm</span></div>
                            <input type="hidden" id="ancho_total_input" name="ancho_total_input" value="<?php echo isset($_POST['ancho_total_input']) ? htmlspecialchars($_POST['ancho_total_input']) : '0' ?>">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="total-item">
                            <div class="total-label">📏 ALTO TOTAL</div>
                            <div class="total-value"><span id="alto_total">0</span> <span class="total-unit">cm</span></div>
                            <input type="hidden" id="alto_total_input" name="alto_total_input" value="<?php echo isset($_POST['alto_total_input']) ? htmlspecialchars($_POST['alto_total_input']) : '0' ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-purple mb-3" style="border: 2px solid #9C27B0; background: #f3e5f5; display: none;" id="escala_card">
                <div class="card-body">
                    <h3 class="card-title" style="color: #6A1B9A; font-size: 1.1rem;">📏 Escala de la imagen PNG</h3>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="info-card">
                                <div class="small text-muted mb-1">Alto del PNG (píxeles)</div>
                                <div class="fs-5 fw-bold" style="color: #7B1FA2;" id="png_alto">-</div>
                                <div class="small text-muted">Se detecta automáticamente</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-card">
                                <div class="small text-muted mb-1">Escala calculada</div>
                                <div class="fs-5 fw-bold" style="color: #7B1FA2;" id="escala_valor">-</div>
                                <div class="small text-muted">píxeles/cm</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 rounded" style="background: #E1BEE7;">
                        <div class="small fw-bold mb-2" style="color: #4A148C;">✓ Offset calculado</div>
                        <div class="fs-4 fw-bold mb-2" style="color: #6A1B9A;" id="offset_calculado">- píxeles</div>
                        <div class="small" style="color: #6A1B9A; font-family: monospace;" id="formula_offset">Fórmula: esperando imagen...</div>
                    </div>
                </div>
            </div>

            <div class="card mb-3" style="border: 2px solid #FF9800; background: #fff3e0;">
                <div class="card-body">
                    <h3 class="card-title" style="color: #E65100; font-size: 1.1rem;">📐 Tamaño del pliego</h3>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label fw-bold small">Alto (cm)</label>
                            <input type="number" class="form-control" step="0.1" name="lienzo_ancho" id="lienzo_ancho" value="<?php echo isset($_POST['lienzo_ancho']) ? htmlspecialchars($_POST['lienzo_ancho']) : '70' ?>" min="0" placeholder="Ancho">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small">Largo (cm)</label>
                            <input type="number" class="form-control" step="0.1" name="lienzo_largo" id="lienzo_largo" value="<?php echo isset($_POST['lienzo_largo']) ? htmlspecialchars($_POST['lienzo_largo']) : '100' ?>" min="0" placeholder="Largo">
                        </div>
                    </div>                   
                </div>
                <div class="slider-container">
                    <label class="form-label fw-bold" style="color: #555; font-size: 0.9rem;">
                        Distancia entre cajas: <span id="distancia_valor" style="color: #FF6F00;"><?php echo isset($_POST['distancia_modelos']) ? htmlspecialchars($_POST['distancia_modelos']) : '0' ?></span> cm
                    </label>
                    <input type="range" class="form-range" id="distancia_modelos" min="0" max="20" value="<?php echo isset($_POST['distancia_modelos']) ? htmlspecialchars($_POST['distancia_modelos']) : '0' ?>" step="1">
                    <style>
                        #distancia_modelos::-webkit-slider-thumb {
                            -webkit-appearance: none;
                            appearance: none;
                            width: 18px;
                            height: 18px;
                            border-radius: 50%;
                            background: #FF9800;
                            cursor: pointer;
                        }

                        #distancia_modelos::-moz-range-thumb {
                            width: 18px;
                            height: 18px;
                            border-radius: 50%;
                            background: #FF9800;
                            cursor: pointer;
                            border: none;
                        }
                    </style>
                </div>
            </div>

            <div class="card mb-3" style="border: 2px solid #2196F3; background: #e3f2fd;">
                <div class="card-body">
                    <h3 class="card-title" style="color: #1565C0; font-size: 1.1rem;">📊 Distribución en lienzo</h3>
                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div class="fw-bold small" style="color: #1976D2; margin-bottom: 8px;">Modelos a lo Alto</div>
                            <div class="display-6 fw-bold" style="color: #0D47A1;" id="modelos_alto">0</div>
                            <input type="hidden" id="hidden_modelos_alto_input" name="hidden_modelos_alto_input" value="<?php echo isset($_POST['hidden_modelos_alto_input']) ? htmlspecialchars($_POST['hidden_modelos_alto_input']) : '0' ?>">
                        </div>
                        <div class="col-4">
                            <div class="fw-bold small" style="color: #1976D2; margin-bottom: 8px;">Modelos a lo largo</div>
                            <div class="display-6 fw-bold" style="color: #0D47A1;" id="modelos_largo">0</div>
                            <input type="hidden" id="hidden_modelos_largo_input" name="hidden_modelos_largo_input" value="<?php echo isset($_POST['hidden_modelos_largo_input']) ? htmlspecialchars($_POST['hidden_modelos_largo_input']) : '0' ?>">
                        </div>
                        <div class="col-4">
                            <div class="fw-bold small" style="color: #1976D2; margin-bottom: 8px;">Total Modelos</div>
                            <div class="display-6 fw-bold" style="color: #0D47A1;" id="total_modelos"><?php echo isset($_POST['hidden_total_modelos_input']) ? htmlspecialchars($_POST['hidden_total_modelos_input']) : '0' ?></div>
                            <input type="hidden" id="hidden_total_modelos_input" name="hidden_total_modelos_input" value="0">
                        </div>
                        <input type="hidden" id="sobrante_ancho_cm" name="sobrante_ancho_cm" value="0">
                        <input type="hidden" id="sobrante_alto_cm" name="sobrante_alto_cm" value="0">
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" role="switch" id="modelos_rotados" name="modelos_rotados" value="1" style="cursor: not-allowed;">
                                <label class="form-check-label fw-bold" for="modelos_rotados" style="color: #1565C0; cursor: not-allowed;">
                                    🔄 Rotación 90° (Auto)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campos hidden para enviar valores calculados -->
            <input type="hidden" name="lienzo_ancho_px" id="lienzo_ancho_px" value="0">
            <input type="hidden" name="lienzo_alto_px" id="lienzo_alto_px" value="0">
            <input type="hidden" name="offset_y" id="hidden_offset_y" value="0">
            <input type="hidden" name="distancia_modelos" id="hidden_distancia_modelos" value="0">

            <input type="hidden" name="tamanyo_original" id="hidden_tamanyo_original" value="1">
            <input type="hidden" name="altoTotalOriginal" id="altoTotalOriginal" value="22.8">
            <input type="hidden" name="anchoTotalOriginal" id="anchoTotalOriginal" value="33.1">

            <button type="button" id="btn_generar" class="btn btn-success btn-lg w-100 mt-3">✨ Generar troquel</button>

        </form>

        <!-- Contenedor para mostrar el resultado -->
        <div id="resultado_container"></div>

        <script>
            let imgHeight = 0;
            let imgWidth = 0;
            let imagenOriginalSrc = null;

            let altoTotalOriginal = 22.8; // Valor original del alto total para referencia en la fórmula
            let anchoTotalOriginal = 33.1; // Valor original del ancho total para referencia en la fórmula

            document.getElementById('ancho_a').addEventListener('input', calcularTotales);
            document.getElementById('ancho_b').addEventListener('input', calcularTotales);
            document.getElementById('ancho_c').addEventListener('input', calcularTotales);
            document.getElementById('ancho_d').addEventListener('input', calcularTotales);
            document.getElementById('ancho_e').addEventListener('input', calcularTotales);

            //Vamos a cargar siempre una plantilla por defecto para que se vea el funcionamiento en móvil sin necesidad de subir una imagen
            window.addEventListener('load', function() {
                const defaultImageSrc = 'Plantilla.png'; // Ruta a la plantilla por defecto
                const previewBox = document.getElementById('preview-box');
                const dimensionesEl = document.getElementById('dimensiones');
                const campoImagen = document.getElementById('imagen');

                const img = new Image();
                img.onload = function() {
                    imgHeight = img.height;
                    imgWidth = img.width;
                    imagenOriginalSrc = defaultImageSrc;

                    // Mostrar dimensiones
                    dimensionesEl.textContent = `Dimensiones imagen: ${img.width}px × ${img.height}px`;
                    dimensionesEl.style.display = 'block';

                    // Mostrar preview
                    previewBox.innerHTML = `<img src="${defaultImageSrc}" alt="Preview" id="preview_img">
                                            
                    <!-- Overlay de líneas de fibra -->
                    <div class="fibra-overlay" id="fibra_overlay"></div>
                    
                    <!-- Control de fibra horizontal (superior) -->
                        <div class="fibra-control top">
                            <span class="fibra-arrow" data-direction="left" title="Fibra hacia la izquierda">←</span>
                            <input class="form-check-input" type="radio" name="direccion_fibra_caja" id="fibra_caja_horizontal" value="horizontal" > 
                             <span class="fibra-label">Fibra</span>
                            <span class="fibra-arrow" data-direction="right" title="Fibra hacia la derecha">→</span>
                        </div>
                        
                        <!-- Control de fibra vertical (lateral derecho) -->
                        <div class="fibra-control right">
                            <span class="fibra-arrow" data-direction="up" title="Fibra hacia arriba">↑</span>
                            <input class="form-check-input" type="radio" name="direccion_fibra_caja" id="fibra_caja_vertical" value="vertical" > 
                            <span class="fibra-label">Fibra</span>
                            <span class="fibra-arrow" data-direction="down" title="Fibra hacia abajo">↓</span>
                        </div>`;
                    previewBox.classList.add('has-image');



                    campoImagen.value = ""; // Limpiar el campo de archivo

                    // Actualizar información de escala
                    document.getElementById('png_alto').textContent = img.height + ' px';

                    // Recalcular totales y escala
                    calcularTotales();
                };
                img.src = defaultImageSrc;
            });

            // Detectar dimensiones de la imagen y mostrar preview
            document.getElementById('imagen').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = new Image();
                        img.onload = function() {
                            imgHeight = img.height;
                            imgWidth = img.width;
                            imagenOriginalSrc = event.target.result;

                            // Mostrar dimensiones
                            const dimensionesEl = document.getElementById('dimensiones');
                            dimensionesEl.textContent = `Dimensiones imagen: ${img.width}px × ${img.height}px`;
                            dimensionesEl.style.display = 'block';

                            // Mostrar preview
                            const previewBox = document.getElementById('preview-box');
                            previewBox.innerHTML = `<img src="${event.target.result}" alt="Preview" id="preview_img">`;
                            previewBox.classList.add('has-image');

                            // Actualizar información de escala
                            document.getElementById('png_alto').textContent = img.height + ' px';

                            // Recalcular totales y escala
                            calcularTotales();
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Calcular totales
            function calcularTotales() {
                let anchoTotal = 0;
                let altoTotal = 0;

                var cx2 = (parseFloat(document.getElementById('ancho_c').value) || 0) * 2;
                var bx2 = (parseFloat(document.getElementById('ancho_b').value) || 0) * 2;
                var e = parseFloat(document.getElementById('ancho_e').value) || 0;
                anchoTotal = bx2 + cx2 + e;

                var a = parseFloat(document.getElementById('ancho_a').value) || 0;
                var dx2 = (parseFloat(document.getElementById('ancho_d').value) || 0) * 2;
                var c = (parseFloat(document.getElementById('ancho_c').value) || 0) * 2;
                altoTotal = a + (c) + (dx2);

                document.getElementById('ancho_total').textContent = anchoTotal.toFixed(1);
                document.getElementById('alto_total').textContent = altoTotal.toFixed(1);

                // Actualizar campos hidden
                document.getElementById('ancho_total_input').value = anchoTotal.toFixed(1);
                document.getElementById('alto_total_input').value = altoTotal.toFixed(1);

                // Calcular escala y offset si tenemos imagen cargada
                if (imgHeight > 0 && altoTotal > 0) {
                    const escala = imgHeight / altoTotal;
                    document.getElementById('escala_valor').textContent = escala.toFixed(2);

                    // Calcular C + D (partes que se solapan)
                    const medidaC = parseFloat(document.getElementById('ancho_c').value) || 0;
                    const medidaD = parseFloat(document.getElementById('ancho_d').value) || 0;

                    const zonaSolapable = (medidaC) + (medidaD);
                    const offsetY = Math.floor(imgHeight - (zonaSolapable * escala));

                    document.getElementById('offset_calculado').textContent = offsetY + ' píxeles';
                    document.getElementById('formula_offset').textContent =
                        `Fórmula: Alto imagen - (C + D) × escala = ${imgHeight}px - (${zonaSolapable.toFixed(1)} cm × ${escala.toFixed(2)} px/cm)`;

                    // Actualizar campo hidden
                    document.getElementById('hidden_offset_y').value = offsetY;
                } else {
                    document.getElementById('escala_valor').textContent = '-';
                    document.getElementById('offset_calculado').textContent = '- píxeles';
                    document.getElementById('formula_offset').textContent = 'Fórmula: esperando imagen...';
                }

                // Calcular distribución en lienzo
                calcularDistribucion(anchoTotal, altoTotal);
            }

            // Calcular cuántos modelos caben en el lienzo
            function calcularDistribucion(anchoTotal, altoTotal) {

                const lienzoAlto = parseFloat(document.getElementById('lienzo_ancho').value) || 0; 
                const lienzoLargo = parseFloat(document.getElementById('lienzo_largo').value) || 0;

                // === SISTEMA DE COMPATIBILIDAD DE FIBRAS ===
                // Convención: dimensiones = Alto × Largo (ej: 70×100 = alto 70, largo 100)
                // Fibra del pliego: SIEMPRE paralela al LARGO (segundo número)
                // Fibra de la caja: seleccionada por el usuario (horizontal ↔️ o vertical ↕️)
                
                // 1️⃣ Determinar dirección de fibra del PLIEGO
                //const fibraPliego = (lienzoLargo > lienzoAlto) ? 'horizontal' : 'vertical';
                const fibraPliego = 'horizontal';
                
                console.log("═══════════════════════════════════════════════════");
                console.log("🧵 SISTEMA DE COMPATIBILIDAD DE FIBRAS");
                console.log("───────────────────────────────────────────────────");
                console.log("📐 PLIEGO: " + lienzoAlto + " × " + lienzoLargo + " cm");
                console.log("   → Largo (" + lienzoLargo + " cm) " + (lienzoLargo > lienzoAlto ? ">" : "<") + " Alto (" + lienzoAlto + " cm)");
                console.log("   → Fibra del pliego: " + fibraPliego.toUpperCase() + " " + (fibraPliego === 'horizontal' ? '↔️' : '↕️'));
                
                // 2️⃣ Obtener dirección de fibra de la CAJA (del usuario)
                const fibraCajaOriginal = document.querySelector('input[name="direccion_fibra_caja"]:checked')?.value;
                
                if (!fibraCajaOriginal) {
                    console.log("⚠️ ADVERTENCIA: No se ha seleccionado dirección de fibra de la caja");
                    console.log("   No se puede calcular distribución sin fibra de caja definida");
                    console.log("═══════════════════════════════════════════════════");
                    
                    document.getElementById('modelos_largo').textContent = '0';
                    document.getElementById('modelos_alto').textContent = '0';
                    document.getElementById('total_modelos').textContent = '0';
                    return;
                }
                
                console.log("📦 CAJA: " + anchoTotal.toFixed(1) + " × " + altoTotal.toFixed(1) + " cm");
                console.log("   → Fibra de la caja (original): " + fibraCajaOriginal.toUpperCase() + " " + (fibraCajaOriginal === 'horizontal' ? '↔️' : '↕️'));
                console.log("───────────────────────────────────────────────────");

                //Si el ancho original o el largo original son 
                // diferentes a los actuales, es que el usuario ha modificado las medidas, 
                // por lo que hay que recalcular el tamaño con el que representaremos la imagen base
                //la imagen puede deformarse

                if (altoTotalOriginal !== altoTotal || anchoTotalOriginal !== anchoTotal) {
                    console.log("🔄 Las medidas de la caja han sido modificadas por el usuario.");
                    console.log("   → Alto total original: " + altoTotalOriginal + " cm");
                    console.log("   → Ancho total original: " + anchoTotalOriginal + " cm");
                    console.log("   → Alto total actual: " + altoTotal.toFixed(1) + " cm");
                    console.log("   → Ancho total actual: " + anchoTotal.toFixed(1) + " cm");
                    console.log("   → Recalculando escala en base a las nuevas medidas y la imagen original...");

                    document.getElementById('hidden_tamanyo_original').value="0";
                    
                }

                // Calcular escala (píxeles por centímetro) basada en la imagen y el alto total
                const escalaPxPorCm = imgHeight / altoTotal;
                document.getElementById('lienzo_ancho_px').value = Math.floor(lienzoLargo * escalaPxPorCm);
                document.getElementById('lienzo_alto_px').value = Math.floor(lienzoAlto * escalaPxPorCm);

                let modelosAncho = 0;
                let modelosAlto = 0;
                let totalModelos = 0;
                
                var zonaSolapable = (parseFloat(document.getElementById('ancho_c').value) || 0) + (parseFloat(document.getElementById('ancho_d').value) || 0);

                let totalA = 0;
                let totalB = 0;
                let anchoA = 0, altoA = 0;
                let anchoB = 0, altoB = 0;

                // 3️⃣ ESCENARIO A: CAJAS SIN ROTAR (orientación vertical)
                // La fibra de la caja mantiene su orientación original
                const fibraCajaEnA = fibraCajaOriginal;
                const compatibleA = (fibraCajaEnA === fibraPliego);
                
                console.log("📐 ESCENARIO A (Cajas SIN ROTAR):");
                console.log("   → Caja: altoTotal (↕️) × anchoTotal (↔️)");
                console.log("   → Fibra de caja en esta orientación: " + fibraCajaEnA.toUpperCase() + " " + (fibraCajaEnA === 'horizontal' ? '↔️' : '↕️'));
                console.log("   → Fibra del pliego: " + fibraPliego.toUpperCase() + " " + (fibraPliego === 'horizontal' ? '↔️' : '↕️'));
                console.log("   → ¿Compatible? " + (compatibleA ? "✓ SÍ" : "✗ NO"));

                if (compatibleA) {
                    anchoA = calcularOpcion(anchoTotal, lienzoLargo, 0);
                    altoA = calcularOpcion(altoTotal, lienzoAlto, zonaSolapable);
                    totalA = anchoA * altoA;
                    console.log("   → Resultado: " + anchoA + " × " + altoA + " = " + totalA + " modelos");
                } else {
                    totalA = 0;
                    console.log("   → DESCARTADO (fibras incompatibles)");
                }

                console.log("───────────────────────────────────────────────────");

                // 4️⃣ ESCENARIO B: CAJAS ROTADAS 90°
                // La fibra de la caja rota 90°
                const fibraCajaEnB = (fibraCajaOriginal === 'horizontal') ? 'vertical' : 'horizontal';
                const compatibleB = (fibraCajaEnB === fibraPliego);
                
                console.log("📐 ESCENARIO B (Cajas ROTADAS 90°):");
                console.log("   → Caja: anchoTotal (↔️) × altoTotal (↕️)");
                console.log("   → Fibra de caja tras rotación: " + fibraCajaEnB.toUpperCase() + " " + (fibraCajaEnB === 'horizontal' ? '↔️' : '↕️'));
                console.log("   → Fibra del pliego: " + fibraPliego.toUpperCase() + " " + (fibraPliego === 'horizontal' ? '↔️' : '↕️'));
                console.log("   → ¿Compatible? " + (compatibleB ? "✓ SÍ" : "✗ NO"));

                if (compatibleB) {
                    //Hay que tener en cuenta que si entramos por aqui es porque hemos rotado las cajas
                    //Si la hemos rotado:
                    anchoB = calcularOpcion(altoTotal, lienzoLargo, zonaSolapable);
                    altoB = calcularOpcion(anchoTotal, lienzoAlto, 0);
                    totalB = anchoB * altoB;
                    console.log("   → Resultado: " + anchoB + " × " + altoB + " = " + totalB + " modelos");
                } else {
                    totalB = 0;
                    console.log("   → DESCARTADO (fibras incompatibles)");
                }

                console.log("───────────────────────────────────────────────────");

                // 5️⃣ ELEGIR EL MEJOR ESCENARIO
                console.log("🎯 DECISIÓN FINAL:");
                console.log("   Escenario A (sin rotar): " + totalA + " modelos " + (compatibleA ? "✓" : "✗"));
                console.log("   Escenario B (rotada 90°): " + totalB + " modelos " + (compatibleB ? "✓" : "✗"));

                if (totalA >= totalB && totalA > 0) {
                    modelosAncho = anchoA;
                    modelosAlto = altoA;
                    console.log("   ✅ SELECCIONADO: Cajas SIN ROTAR - " + totalA + " modelos");
                    document.getElementById('modelos_rotados').checked = false;
                } else if (totalB > 0) {
                    modelosAncho = anchoB;
                    modelosAlto = altoB;
                    console.log("   ✅ SELECCIONADO: Cajas ROTADAS 90° - " + totalB + " modelos");
                    document.getElementById('modelos_rotados').checked = true;
                    console.log("   🔄 Checkbox modelos_rotados marcado para rotación física");
                } else {
                    console.log("   ⚠️ NINGUNA OPCIÓN VÁLIDA - Fibras incompatibles en ambos escenarios");
                    modelosAncho = 0;
                    modelosAlto = 0;
                    document.getElementById('modelos_rotados').checked = false;
                }

                console.log("═══════════════════════════════════════════════════");

                /*//var zonaSolapable = (parseFloat(document.getElementById('ancho_c').value) || 0) + (parseFloat(document.getElementById('ancho_d').value) || 0);
                //console.log("Zona solapable: " + zonaSolapable);
                var distanciCajas = parseFloat(document.getElementById('hidden_distancia_modelos').value) || 0;
                //console.log("Distancia entre cajas: " + distanciCajas);
                var cajasAlto = 1; //Que mide una caja de alto? altoTotal cm Empiezo metiendo ya una caja
                //console.log("inicio lienzoLargo: " + lienzoLargo);
                //console.log("Inicio  altoTotal: " + altoTotal);
                lienzoLargoTemp = lienzoLargo - altoTotal - distanciCajas; //Restamos la primera caja
                //console.log("Inicio  lienzoLargoTemp: " + lienzoLargoTemp);


                while (lienzoLargoTemp > altoTotal) { //mientras quepa una caja, vamos añadiendo pero hay que tener en cuenta que se solapan
                    cajasAlto++;
                    lienzoLargoTemp -= altoTotal - zonaSolapable;
                    //console.log("1 - Resto lienzoLargoTemp: " + lienzoLargoTemp);
                    lienzoLargoTemp -= distanciCajas; //restamos lo que ocupa la caja menos lo que se solapa y la distancia entre cajas
                    //console.log("Cajas a lo alto: " + cajasAlto);
                    //console.log("Resto lienzoLargoTemp: " + lienzoLargoTemp);
                    //console.log("Espacio ocupado: " + (lienzoLargo - lienzoLargoTemp));
                }



                modelosAlto = cajasAlto;*/



                console.log("Modelos Ancho: " + modelosAncho);
                console.log("Modelos Alto: " + modelosAlto);

                totalModelos = modelosAncho * modelosAlto;

                document.getElementById('modelos_largo').textContent = modelosAncho;
                document.getElementById('modelos_alto').textContent = modelosAlto;
                document.getElementById('total_modelos').textContent = totalModelos;

                // Actualizar campos hidden para el POST
                document.getElementById('hidden_modelos_largo_input').value = modelosAncho;
                document.getElementById('hidden_modelos_alto_input').value = modelosAlto;
            }

            // Event listeners para campos del lienzo
            document.getElementById('lienzo_ancho').addEventListener('input', calcularTotales);
            document.getElementById('lienzo_largo').addEventListener('input', calcularTotales);
            document.getElementById('distancia_modelos').addEventListener('input', calcularTotales);

            // Event listener para el slider de distancia
            document.getElementById('distancia_modelos').addEventListener('input', function(e) {
                document.getElementById('distancia_valor').textContent = e.target.value;
                document.getElementById('hidden_distancia_modelos').value = e.target.value;
            });
            
            // === CONTROL DE OVERLAY DE FIBRA ===
            function actualizarOverlayFibra() {
                const overlay = document.getElementById('fibra_overlay');
                const radioHorizontal = document.getElementById('fibra_caja_horizontal');
                const radioVertical = document.getElementById('fibra_caja_vertical');
                
                if (!overlay) return;
                
                // Resetear clases
                overlay.classList.remove('visible', 'horizontal', 'vertical');
                
                if (radioHorizontal && radioHorizontal.checked) {
                    overlay.classList.add('visible', 'horizontal');
                    console.log('🧵 Overlay de fibra HORIZONTAL activado');
                } else if (radioVertical && radioVertical.checked) {
                    overlay.classList.add('visible', 'vertical');
                    console.log('🧵 Overlay de fibra VERTICAL activado');
                } else {
                    console.log('🧵 Overlay de fibra desactivado');
                }
            }
            
            // Event listeners para los controles de fibra de la caja
            document.addEventListener('change', function(e) {
                if (e.target.name === 'direccion_fibra_caja') {
                    console.log("🔄 Fibra de caja cambiada a: " + e.target.value);
                    actualizarOverlayFibra();
                    calcularTotales(); // Recalcular distribución con nueva fibra
                }
            });

            function calcularOpcion(medidaCaja, medidaLienzo, zonaSolapable) {
                console.log("═══════════════════════════════════════════════════");
                console.log("🔧 INICIO calcularOpcion()");
                console.log("   📦 Medida de la caja: " + medidaCaja + " cm");
                console.log("   📐 Medida del lienzo disponible: " + medidaLienzo + " cm");
                console.log("   ↔️  Zona solapable (C+D): " + zonaSolapable + " cm");

                var distanciCajas = parseFloat(document.getElementById('hidden_distancia_modelos').value) || 0;
                console.log("   📏 Distancia entre cajas: " + distanciCajas + " cm");
                console.log("───────────────────────────────────────────────────");

                var cajasInsertadas = 1;
                console.log("✅ Primera caja insertada (cajasInsertadas = 1)");

                lienzoLargoTemp = medidaLienzo - medidaCaja - distanciCajas;
                console.log("📊 Espacio restante tras primera caja:");
                console.log("   " + medidaLienzo + " - " + medidaCaja + " - " + distanciCajas + " = " + lienzoLargoTemp.toFixed(2) + " cm");
                console.log("───────────────────────────────────────────────────");

                var iteracion = 1;
                while (lienzoLargoTemp > medidaCaja) {
                    console.log("🔄 Iteración " + iteracion + ": Comprobando si cabe otra caja...");
                    console.log("   ¿" + lienzoLargoTemp.toFixed(2) + " cm > " + medidaCaja + " cm? ✓ SÍ");

                    cajasInsertadas++;
                    console.log("   ✅ Caja #" + cajasInsertadas + " insertada");

                    lienzoLargoTemp -= medidaCaja - zonaSolapable;
                    console.log("   🔻 Restando: " + medidaCaja + " - " + zonaSolapable + " (solapamiento) = " + (medidaCaja - zonaSolapable).toFixed(2) + " cm");
                    console.log("   📍 Espacio tras restar caja: " + lienzoLargoTemp.toFixed(2) + " cm");

                    lienzoLargoTemp -= distanciCajas;
                    console.log("   🔻 Restando distancia: " + distanciCajas + " cm");
                    console.log("   📍 Espacio final restante: " + lienzoLargoTemp.toFixed(2) + " cm");
                    console.log("   📏 Espacio ocupado total: " + (medidaLienzo - lienzoLargoTemp).toFixed(2) + " cm");
                    console.log("───────────────────────────────────────────────────");

                    iteracion++;
                }

                console.log("⛔ Bucle finalizado: No cabe otra caja");
                console.log("   ¿" + lienzoLargoTemp.toFixed(2) + " cm > " + medidaCaja + " cm? ✗ NO");
                console.log("🎯 RESULTADO: " + cajasInsertadas + " cajas caben en " + medidaLienzo + " cm");
                console.log("   📊 Espacio utilizado: " + (medidaLienzo - lienzoLargoTemp).toFixed(2) + " cm");
                console.log("   📊 Espacio sobrante: " + lienzoLargoTemp.toFixed(2) + " cm");

                console.log("═══════════════════════════════════════════════════");

                return cajasInsertadas;

            }

            // === ENVÍO VÍA AJAX ===
            document.getElementById('btn_generar').addEventListener('click', function() {
                console.log("🚀 Iniciando generación de troquel vía AJAX...");

                // Crear FormData con todos los campos del formulario
                const formData = new FormData(document.querySelector('form'));

                // Mostrar indicador de carga
                const btnGenerar = this;
                const textoOriginal = btnGenerar.innerHTML;
                btnGenerar.innerHTML = '⏳ Generando...';
                btnGenerar.disabled = true;

                console.log("📦 Datos del formulario:");
                for (let pair of formData.entries()) {
                    console.log(`   ${pair[0]}: ${pair[1]}`);
                }

                // Enviar petición AJAX
                fetch('imageGenerator.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log("📡 Respuesta recibida del servidor");
                        return response.json();
                    })
                    .then(data => {
                        console.log("✅ Datos procesados:", data);

                        // Restaurar botón
                        btnGenerar.innerHTML = textoOriginal;
                        btnGenerar.disabled = false;

                        if (data.success) {
                            // Mostrar resultado
                            const container = document.getElementById('resultado_container');
                            container.innerHTML = `
                            <div class="resultado mt-4">
                                <h3 class="text-success mb-3">✅ Troquel generado</h3>
                                <img src="${data.imagen}" alt="Troquel generado" height="${data.debug.lienzo_alto_px}px" width="${data.debug.lienzo_ancho_px}px" style="border: 2px solid #4CAF50; border-radius: 8px;">
                                <p class="mt-3">
                                    <a href="${data.imagen}" download class="btn btn-primary">⬇️ Descargar imagen</a>
                                </p>
                            </div>
                        `;

                            // Scroll al resultado
                            container.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });
                        } else {
                            // Mostrar error
                            alert('❌ Error: ' + (data.error || 'Error desconocido'));
                            console.error("Error del servidor:", data);
                        }
                    })
                    .catch(error => {
                        console.error("❌ Error en la petición AJAX:", error);
                        alert('Error al generar el troquel. Por favor, revisa la consola.');

                        // Restaurar botón
                        btnGenerar.innerHTML = textoOriginal;
                        btnGenerar.disabled = false;
                    });
            });

            // Calcular al cargar
            //calcularTotales();
        </script>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>