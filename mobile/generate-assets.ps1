Add-Type -AssemblyName System.Drawing

$assetsDir = Join-Path $PSScriptRoot "assets"
if (-not (Test-Path $assetsDir)) {
    New-Item -ItemType Directory -Path $assetsDir | Out-Null
}

$imgDir = Join-Path $PSScriptRoot "src\img"
if (-not (Test-Path $imgDir)) {
    New-Item -ItemType Directory -Path $imgDir | Out-Null
}

function Generate-Icon {
    param([string]$outputPath, [int]$size = 1024)

    $bmp = New-Object System.Drawing.Bitmap $size, $size
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
    $g.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
    $g.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality

    # Background gradient
    $rect = New-Object System.Drawing.Rectangle 0, 0, $size, $size
    $cTop = [System.Drawing.ColorTranslator]::FromHtml("#160c28")
    $cBottom = [System.Drawing.ColorTranslator]::FromHtml("#07040d")
    $brush = New-Object System.Drawing.Drawing2D.LinearGradientBrush $rect, $cTop, $cBottom, 45.0
    $g.FillRectangle($brush, $rect)

    # Ambient glow in center
    $glowBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(45, 168, 85, 247))
    $g.FillEllipse($glowBrush, [int]($size * 0.22), [int]($size * 0.22), [int]($size * 0.56), [int]($size * 0.56))

    # Metronome Body Polygon
    $p1 = New-Object System.Drawing.Point ([int]($size * 0.33)), ([int]($size * 0.74))
    $p2 = New-Object System.Drawing.Point ([int]($size * 0.44)), ([int]($size * 0.26))
    $p3 = New-Object System.Drawing.Point ([int]($size * 0.56)), ([int]($size * 0.26))
    $p4 = New-Object System.Drawing.Point ([int]($size * 0.67)), ([int]($size * 0.74))
    $poly = @($p1, $p2, $p3, $p4)

    # Inner body fill
    $innerBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(35, 168, 85, 247))
    $g.FillPolygon($innerBrush, $poly)

    # Body Stroke
    $penWidth = [float]($size * 0.034)
    $bodyColor = [System.Drawing.ColorTranslator]::FromHtml("#a855f7")
    $bodyPen = New-Object System.Drawing.Pen($bodyColor, $penWidth)
    $bodyPen.StartCap = [System.Drawing.Drawing2D.LineCap]::Round
    $bodyPen.EndCap = [System.Drawing.Drawing2D.LineCap]::Round
    $bodyPen.LineJoin = [System.Drawing.Drawing2D.LineJoin]::Round
    $g.DrawPolygon($bodyPen, $poly)

    # Base line
    $g.DrawLine($bodyPen, [int]($size * 0.29), [int]($size * 0.74), [int]($size * 0.71), [int]($size * 0.74))

    # Pendulum Rod
    $rodWidth = [float]($size * 0.032)
    $rodColor = [System.Drawing.ColorTranslator]::FromHtml("#38bdf8")
    $rodPen = New-Object System.Drawing.Pen($rodColor, $rodWidth)
    $rodPen.StartCap = [System.Drawing.Drawing2D.LineCap]::Round
    $rodPen.EndCap = [System.Drawing.Drawing2D.LineCap]::Round
    $g.DrawLine($rodPen, [int]($size * 0.50), [int]($size * 0.71), [int]($size * 0.70), [int]($size * 0.27))

    # Pendulum Weight
    $state = $g.Save()
    $g.TranslateTransform([float]($size * 0.62), [float]($size * 0.43))
    $g.RotateTransform(-30.0)
    $wBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml("#38bdf8"))
    $wW = [int]($size * 0.075)
    $wH = [int]($size * 0.050)
    $g.FillRectangle($wBrush, [int](-$wW / 2), [int](-$wH / 2), $wW, $wH)
    $g.Restore($state)

    # Pivot circle
    $pivotBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml("#c084fc"))
    $pDia = [int]($size * 0.06)
    $g.FillEllipse($pivotBrush, [int]($size * 0.47), [int]($size * 0.68), $pDia, $pDia)

    $bmp.Save($outputPath, [System.Drawing.Imaging.ImageFormat]::Png)
    $g.Dispose()
    $bmp.Dispose()
    Write-Host "Generado icono: $outputPath"
}

function Generate-Splash {
    param([string]$outputPath, [int]$width = 2732, [int]$height = 2732)

    $bmp = New-Object System.Drawing.Bitmap $width, $height
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
    $g.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic

    # Dark gradient background
    $rect = New-Object System.Drawing.Rectangle 0, 0, $width, $height
    $cTop = [System.Drawing.ColorTranslator]::FromHtml("#160c28")
    $cBottom = [System.Drawing.ColorTranslator]::FromHtml("#07040d")
    $brush = New-Object System.Drawing.Drawing2D.LinearGradientBrush $rect, $cTop, $cBottom, 45.0
    $g.FillRectangle($brush, $rect)

    # Center Icon scaled at 40% of screen
    $iconSize = [int]($width * 0.28)
    $iconX = [int](($width - $iconSize) / 2)
    $iconY = [int]($height * 0.36)

    # Glow
    $glowBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(40, 168, 85, 247))
    $g.FillEllipse($glowBrush, [int]($iconX - 80), [int]($iconY - 80), [int]($iconSize + 160), [int]($iconSize + 160))

    # Metronome Body in splash
    $p1 = New-Object System.Drawing.Point ([int]($iconX + $iconSize * 0.33)), ([int]($iconY + $iconSize * 0.74))
    $p2 = New-Object System.Drawing.Point ([int]($iconX + $iconSize * 0.44)), ([int]($iconY + $iconSize * 0.26))
    $p3 = New-Object System.Drawing.Point ([int]($iconX + $iconSize * 0.56)), ([int]($iconY + $iconSize * 0.26))
    $p4 = New-Object System.Drawing.Point ([int]($iconX + $iconSize * 0.67)), ([int]($iconY + $iconSize * 0.74))
    $poly = @($p1, $p2, $p3, $p4)

    $innerBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::FromArgb(35, 168, 85, 247))
    $g.FillPolygon($innerBrush, $poly)

    $sPenWidth = [float]($iconSize * 0.034)
    $sBodyColor = [System.Drawing.ColorTranslator]::FromHtml("#a855f7")
    $bodyPen = New-Object System.Drawing.Pen($sBodyColor, $sPenWidth)
    $bodyPen.StartCap = [System.Drawing.Drawing2D.LineCap]::Round
    $bodyPen.EndCap = [System.Drawing.Drawing2D.LineCap]::Round
    $bodyPen.LineJoin = [System.Drawing.Drawing2D.LineJoin]::Round
    $g.DrawPolygon($bodyPen, $poly)

    $g.DrawLine($bodyPen, [int]($iconX + $iconSize * 0.29), [int]($iconY + $iconSize * 0.74), [int]($iconX + $iconSize * 0.71), [int]($iconY + $iconSize * 0.74))

    $sRodWidth = [float]($iconSize * 0.032)
    $sRodColor = [System.Drawing.ColorTranslator]::FromHtml("#38bdf8")
    $rodPen = New-Object System.Drawing.Pen($sRodColor, $sRodWidth)
    $rodPen.StartCap = [System.Drawing.Drawing2D.LineCap]::Round
    $rodPen.EndCap = [System.Drawing.Drawing2D.LineCap]::Round
    $g.DrawLine($rodPen, [int]($iconX + $iconSize * 0.50), [int]($iconY + $iconSize * 0.71), [int]($iconX + $iconSize * 0.70), [int]($iconY + $iconSize * 0.27))

    $state = $g.Save()
    $g.TranslateTransform([float]($iconX + $iconSize * 0.62), [float]($iconY + $iconSize * 0.43))
    $g.RotateTransform(-30.0)
    $wBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml("#38bdf8"))
    $wW = [int]($iconSize * 0.075)
    $wH = [int]($iconSize * 0.050)
    $g.FillRectangle($wBrush, [int](-$wW / 2), [int](-$wH / 2), $wW, $wH)
    $g.Restore($state)

    $pivotBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml("#c084fc"))
    $pDia = [int]($iconSize * 0.06)
    $g.FillEllipse($pivotBrush, [int]($iconX + $iconSize * 0.47), [int]($iconY + $iconSize * 0.68), $pDia, $pDia)

    # Typography "eBand"
    $fontFamily = New-Object System.Drawing.FontFamily("Arial")
    $fontTitle = New-Object System.Drawing.Font($fontFamily, 90, [System.Drawing.FontStyle]::Bold, [System.Drawing.GraphicsUnit]::Pixel)
    $fontSub = New-Object System.Drawing.Font($fontFamily, 36, [System.Drawing.FontStyle]::Regular, [System.Drawing.GraphicsUnit]::Pixel)

    $format = New-Object System.Drawing.StringFormat
    $format.Alignment = [System.Drawing.StringAlignment]::Center

    $textBrushWhite = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml("#ffffff"))
    $textBrushMuted = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml("#94a3b8"))

    $g.DrawString("eBand", $fontTitle, $textBrushWhite, [float]($width / 2), [float]($iconY + $iconSize + 60), $format)
    $g.DrawString("Tu agrupacion musical siempre contigo", $fontSub, $textBrushMuted, [float]($width / 2), [float]($iconY + $iconSize + 170), $format)

    $bmp.Save($outputPath, [System.Drawing.Imaging.ImageFormat]::Png)
    $g.Dispose()
    $bmp.Dispose()
    Write-Host "Generado splash: $outputPath"
}

# 1. Generar iconos base (1024x1024)
$iconPath = Join-Path $assetsDir "icon.png"
$logoPath = Join-Path $assetsDir "logo.png"
$webIconPath = Join-Path $imgDir "logo.png"

Generate-Icon -outputPath $iconPath
Copy-Item $iconPath $logoPath -Force
Copy-Item $iconPath $webIconPath -Force

# 2. Generar splash screen (2732x2732)
$splashPath = Join-Path $assetsDir "splash.png"
$splashDarkPath = Join-Path $assetsDir "splash-dark.png"
Generate-Splash -outputPath $splashPath
Copy-Item $splashPath $splashDarkPath -Force

Write-Host "Assets generados correctamente en mobile/assets/"
