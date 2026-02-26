<?php
// Configurar respuesta como JSON
header('Content-Type: application/json');

$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        // Determinar qué imagen usar
        $rutaImagen = null;

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Usuario subió una imagen
            if ($_FILES['imagen']['type'] !== 'image/png') {
                echo json_encode([
                    'success' => false,
                    'error' => 'Solo se permiten archivos PNG'
                ]);
                exit;
            }
            $rutaImagen = $_FILES['imagen']['tmp_name'];
        } else {
            // No se subió imagen, usar plantilla por defecto
            $rutaImagen = 'Plantilla.png';
            if (!file_exists($rutaImagen)) {
                echo json_encode([
                    'success' => false,
                    'error' => 'No se encontró la plantilla por defecto (Plantilla.png)'
                ]);
                exit;
            }
        }

        $tamanyo_original = isset($_POST['tamanyo_original']) ? $_POST['tamanyo_original'] : '1';

        $altoTotalOriginal = isset($_POST['altoTotalOriginal']) ? floatval($_POST['altoTotalOriginal']) : 22.8;
        $anchoTotalOriginal = isset($_POST['anchoTotalOriginal']) ? floatval($_POST['anchoTotalOriginal']) : 33.1;

        $altoTotal = floatval($_POST['alto_total_input'] ?? 0);
        $anchoTotal = floatval($_POST['ancho_total_input'] ?? 0);

        //Si tamaño original es = 0 es porque el uusuario ha cambiado las medidas
        if ($tamanyo_original === '0') {

            /* === CARGAR Y REDIMENSIONAR IMAGEN === */
            $img = imagecreatefrompng($rutaImagen);
            $imgW = imagesx($img);
            $imgH = imagesy($img);

            // Calcular factores de escala
            $factorEscalaAncho = $anchoTotal / $anchoTotalOriginal;
            $factorEscalaAlto = $altoTotal / $altoTotalOriginal;

            // Nuevas dimensiones en píxeles
            $nuevoW = intval($imgW * $factorEscalaAncho);
            $nuevoH = intval($imgH * $factorEscalaAlto);

            // Crear imagen redimensionada
            $imgRedimensionada = imagecreatetruecolor($nuevoW, $nuevoH);
            imagealphablending($imgRedimensionada, false);
            imagesavealpha($imgRedimensionada, true);

            $trans = imagecolorallocatealpha($imgRedimensionada, 0, 0, 0, 127);
            imagefill($imgRedimensionada, 0, 0, $trans);

            // Copiar y redimensionar (permite deformación)
            imagecopyresampled(
                $imgRedimensionada,
                $img,
                0,
                0,
                0,
                0,
                $nuevoW,
                $nuevoH,
                $imgW,
                $imgH
            );

            imagedestroy($img);
            $img = $imgRedimensionada;
            $imgW = $nuevoW;
            $imgH = $nuevoH;
        } else {
            /* === CARGAR IMAGEN BASE SIN MODIFICAR === */
            $img = imagecreatefrompng($rutaImagen);
            $imgW = imagesx($img);
            $imgH = imagesy($img);
        }

        /* === PARAMETROS === */
        // Obtener modelos de la distribución calculada en el frontend
        $modelosAncho = max(1, intval($_POST['hidden_modelos_largo_input'] ?? 1));
        $modelosAlto = max(1, intval($_POST['hidden_modelos_alto_input'] ?? 1));

        // Dimensiones del lienzo en píxeles
        // Convención: lienzo_ancho = ALTO (70), lienzo_largo = LARGO (100)
        // lienzo_ancho_px = píxeles del ALTO, lienzo_alto_px = píxeles del LARGO
        $lienzoAnchoPx = floatval($_POST['lienzo_ancho_px'] ?? 0);
        $lienzoAltoPx = floatval($_POST['lienzo_alto_px'] ?? 0);

        // Calcular ancho y alto total usando las fórmulas correctas
        // Alto = A + (C×2) + (D×2)
        $altoTotal = floatval($_POST['alto_total_input'] ?? 0);

        // Ancho = (B×2) + (C×2) + E
        $anchoTotal = floatval($_POST['ancho_total_input'] ?? 0);

        $modelos_rotados = isset($_POST['modelos_rotados']) ? true : false;

        // === ESCALAR IMAGEN A MAYOR RESOLUCIÓN (3x) ===
        $multiplicadorResolucion = 1;
        $escala = ($altoTotal > 0) ? ($imgH / $altoTotal) * $multiplicadorResolucion : 1;

        $nuevoAncho = intval($imgW * $multiplicadorResolucion);
        $nuevoAlto = intval($imgH * $multiplicadorResolucion);

        $imgEscalada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagealphablending($imgEscalada, false);
        imagesavealpha($imgEscalada, true);

        $transparent = imagecolorallocatealpha($imgEscalada, 0, 0, 0, 127);
        imagefill($imgEscalada, 0, 0, $transparent);
        imagealphablending($imgEscalada, true);

        // Usar imagecopyresampled para mejor calidad
        imagecopyresampled(
            $imgEscalada,
            $img,
            0,
            0,
            0,
            0,
            $nuevoAncho,
            $nuevoAlto,
            $imgW,
            $imgH
        );

        // Liberar imagen original y usar la escalada
        imagedestroy($img);
        $img = $imgEscalada;
        $imgW = $nuevoAncho;
        $imgH = $nuevoAlto;

        // Guardar imagen procesada en fichero temporal
        $nombreTemp = 'imagenes/temp_img_' . time() . '.png';
        imagepng($img, $nombreTemp);

        // Calcular escala: px/cm
        $escalax = ($anchoTotal > 0) ? $imgW / $anchoTotal : 1;
        $escalay = ($altoTotal > 0) ? $imgH / $altoTotal : 1;

        // Si hay que rotar, aplicar rotación de 90° a la imagen
        if ($modelos_rotados) {
            // Rotar 90° en sentido horario
            $transparente = imagecolorallocatealpha($img, 0, 0, 0, 127);
            $imgRotada = imagerotate($img, -90, $transparente);

            imagealphablending($imgRotada, false);
            imagesavealpha($imgRotada, true);

            // Liberar imagen original y usar la rotada
            imagedestroy($img);
            $img = $imgRotada;

            // Guardar imagen procesada en fichero temporal
            $nombreTemp = 'imagenes/temp_img_rota_' . time() . '.png';
            imagepng($img, $nombreTemp);

            // Actualizar dimensiones (se intercambian)
            $imgW = imagesx($img);
            $imgH = imagesy($img);
            //$imgW = imagesy($img);
            //$imgH = imagesx($img);

            $altoTotal = floatval($_POST['ancho_total_input'] ?? 0);
            $anchoTotal = floatval($_POST['alto_total_input'] ?? 0);

            $escalax = ($anchoTotal > 0) ? $imgW / $anchoTotal : 1;
            $escalay = ($altoTotal > 0) ? $imgH / $altoTotal : 1;
        }



        // Obtener offset calculado desde el frontend
        $offsetY = intval($_POST['offset_y'] ?? $imgH);
        $offsetX = $imgW;

        if ($modelos_rotados) {
            $offsetY = intval($_POST['offset_y'] ?? $imgW);
            $offsetX = $imgH;
        }


        // Si hay rotación, ajustar offsets (se intercambian las referencias)
        if ($modelos_rotados) {
            // Cuando rotamos, lo que era alto ahora es ancho y viceversa
            // El offset que se calculó para Y ahora aplica a X
            $tempOffset = $offsetY;
            $offsetY = $offsetX;
            $offsetX = $tempOffset;
        }

        // Obtener distancia entre modelos en cm y convertir a píxeles
        $distanciaCm = floatval($_POST['distancia_modelos'] ?? 0);
        $distanciaPx = intval($distanciaCm * $escalay);

        // Añadir la distancia al offset
        $offsetYFinal = $offsetY + $distanciaPx;
        $offsetXFinal = $offsetX + intval($distanciaCm * $escalax);

        /* === CALCULAR CANVAS FINAL === */
        // Con offset + distancia, el tamaño es: imagen base + (offset + distancia) × (modelos - 1)
        $finalW = ($imgW + ($offsetXFinal * ($modelosAncho - 1)))*$modelosAncho;
        $finalH = ($imgH + ($offsetYFinal * ($modelosAlto - 1)))*$modelosAlto;

        /* === CREAR CANVAS === */
        //$canvas = imagecreatetruecolor($finalW, $finalH);
        // Convención: lienzo_ancho_px = ALTO del pliego, lienzo_alto_px = LARGO del pliego
        // imagecreatetruecolor(ancho, alto) → usamos (LARGO, ALTO)
        //$canvas = imagecreatetruecolor($lienzoAnchoPx, $lienzoAltoPx);
        $canvas = imagecreatetruecolor($finalW, $finalH);
        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);

        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefill($canvas, 0, 0, $transparent);
        imagealphablending($canvas, true);

        /* === APILAR CAJAS EN GRID 2D === */
        for ($fila = 0; $fila < $modelosAlto; $fila++) {
            for ($col = 0; $col < $modelosAncho; $col++) {
                $x = intval($col * $offsetXFinal);
                $y = intval($fila * $offsetYFinal);

                imagecopy($canvas, $img, $x, $y, 0, 0, $imgW, $imgH);
            }
        }

        imagedestroy($img);

        /* === GUARDAR === */
        $nombre = 'imagenes/result_' . time() . '.png';

        if (!imagepng($canvas, $nombre)) {
            imagedestroy($canvas);
            echo json_encode([
                'success' => false,
                'error' => 'Error al guardar la imagen generada'
            ]);
            exit;
        }

        imagedestroy($canvas);

        // Devolver respuesta exitosa
        echo json_encode([
            'success' => true,
            'imagen' => $nombre,
            'debug' => [
                'modelos_ancho' => $modelosAncho,
                'modelos_alto' => $modelosAlto,
                'total_modelos' => $modelosAncho * $modelosAlto,
                'rotacion' => $modelos_rotados ? 'Si' : 'No',
                'direccion_fibra' => $_POST['direccion_fibra'] ?? 'ninguno',
                'lienzo_alto_px' => $lienzoAltoPx,
                'lienzo_ancho_px' => $lienzoAnchoPx
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Error interno: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Método de petición no válido'
    ]);
}
