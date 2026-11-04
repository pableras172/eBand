const fs = require('fs');
const path = require('path');
const sharp = require('sharp');

const ASSETS_DIR = path.join(__dirname, 'assets');
const SRC_IMG_DIR = path.join(__dirname, 'src', 'img');

if (!fs.existsSync(ASSETS_DIR)) fs.mkdirSync(ASSETS_DIR, { recursive: true });
if (!fs.existsSync(SRC_IMG_DIR)) fs.mkdirSync(SRC_IMG_DIR, { recursive: true });

const rawMetronomeSvg = fs.readFileSync(path.join(ASSETS_DIR, 'metronome-svgrepo-com.svg'), 'utf8');

// Extract the inner SVG elements from metronome-svgrepo-com.svg
const innerSvgContent = rawMetronomeSvg
  .replace(/<\?xml[\s\S]*?\?>/i, '')
  .replace(/<!--[\s\S]*?-->/g, '')
  .replace(/<svg[\s\S]*?>/i, '')
  .replace(/<\/svg>/i, '')
  .trim();

async function generateAppIcon() {
  const size = 1024;
  const metroSize = 680;
  const metroOffset = (size - metroSize) / 2;

  const iconSvg = `
  <svg width="${size}" height="${size}" viewBox="0 0 ${size}" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#1e1b4b" />
        <stop offset="50%" stop-color="#0f172a" />
        <stop offset="100%" stop-color="#020617" />
      </linearGradient>
      <radialGradient id="ambientGlow" cx="50%" cy="50%" r="50%">
        <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.25" />
        <stop offset="40%" stop-color="#818cf8" stop-opacity="0.12" />
        <stop offset="100%" stop-color="#0f172a" stop-opacity="0" />
      </radialGradient>
      <filter id="metroShadow" x="-15%" y="-15%" width="130%" height="130%">
        <feDropShadow dx="0" dy="18" stdDeviation="24" flood-color="#000000" flood-opacity="0.55" />
      </filter>
    </defs>

    <!-- Full canvas background -->
    <rect width="${size}" height="${size}" fill="url(#bgGrad)" />

    <!-- Ambient circular glow -->
    <circle cx="512" cy="512" r="420" fill="url(#ambientGlow)" />

    <!-- Tempo pulse subtle rings -->
    <circle cx="512" cy="512" r="380" fill="none" stroke="#38bdf8" stroke-opacity="0.1" stroke-width="2" />
    <circle cx="512" cy="512" r="440" fill="none" stroke="#a855f7" stroke-opacity="0.08" stroke-width="1.5" />

    <!-- Metronome Graphic -->
    <g transform="translate(${metroOffset}, ${metroOffset}) scale(${metroSize / 481.6})" filter="url(#metroShadow)">
      ${innerSvgContent}
    </g>
  </svg>
  `;

  const iconPngBuffer = await sharp(Buffer.from(iconSvg)).png().toBuffer();
  fs.writeFileSync(path.join(ASSETS_DIR, 'icon.png'), iconPngBuffer);
  fs.writeFileSync(path.join(ASSETS_DIR, 'logo.png'), iconPngBuffer);
  fs.writeFileSync(path.join(SRC_IMG_DIR, 'logo.png'), iconPngBuffer);
  console.log('Generado icono eBand (1024x1024):', path.join(ASSETS_DIR, 'icon.png'));
}

async function generateSplashScreen() {
  const width = 2732;
  const height = 2732;
  const metroSize = 780;
  const metroX = (width - metroSize) / 2;
  const metroY = height * 0.33;

  const splashSvg = `
  <svg width="${width}" height="${height}" viewBox="0 0 ${width} ${height}" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="splashBg" x1="0%" y1="0%" x2="0%" y2="100%">
        <stop offset="0%" stop-color="#1e1b4b" />
        <stop offset="45%" stop-color="#0f172a" />
        <stop offset="100%" stop-color="#020617" />
      </linearGradient>
      <radialGradient id="splashGlow" cx="50%" cy="40%" r="50%">
        <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.22" />
        <stop offset="50%" stop-color="#818cf8" stop-opacity="0.08" />
        <stop offset="100%" stop-color="#0f172a" stop-opacity="0" />
      </radialGradient>
      <filter id="splashShadow" x="-20%" y="-20%" width="140%" height="140%">
        <feDropShadow dx="0" dy="24" stdDeviation="32" flood-color="#000000" flood-opacity="0.6" />
      </filter>
    </defs>

    <!-- Background -->
    <rect width="${width}" height="${height}" fill="url(#splashBg)" />

    <!-- Ambient glow behind metronome -->
    <circle cx="${width / 2}" cy="${metroY + metroSize / 2}" r="640" fill="url(#splashGlow)" />

    <!-- Concentric tempo sound rings -->
    <circle cx="${width / 2}" cy="${metroY + metroSize / 2}" r="540" fill="none" stroke="#38bdf8" stroke-opacity="0.12" stroke-width="2.5" />
    <circle cx="${width / 2}" cy="${metroY + metroSize / 2}" r="700" fill="none" stroke="#818cf8" stroke-opacity="0.08" stroke-width="2" />

    <!-- Metronome -->
    <g transform="translate(${metroX}, ${metroY}) scale(${metroSize / 481.6})" filter="url(#splashShadow)">
      ${innerSvgContent}
    </g>

    <!-- Typography eBand -->
    <text x="${width / 2}" y="${metroY + metroSize + 110}" 
          font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif" 
          font-size="116" font-weight="800" fill="#ffffff" text-anchor="middle" letter-spacing="-1">eBand</text>

    <!-- Subtitle -->
    <text x="${width / 2}" y="${metroY + metroSize + 180}" 
          font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif" 
          font-size="44" font-weight="500" fill="#94a3b8" text-anchor="middle" letter-spacing="0.5">Tu agrupación musical siempre contigo</text>
  </svg>
  `;

  const splashPngBuffer = await sharp(Buffer.from(splashSvg)).png().toBuffer();
  fs.writeFileSync(path.join(ASSETS_DIR, 'splash.png'), splashPngBuffer);
  fs.writeFileSync(path.join(ASSETS_DIR, 'splash-dark.png'), splashPngBuffer);
  console.log('Generado splash screen eBand (2732x2732):', path.join(ASSETS_DIR, 'splash.png'));
}

async function run() {
  await generateAppIcon();
  await generateSplashScreen();
  console.log('Assets de metrónomo generados con éxito.');
}

run().catch((err) => {
  console.error('Error generando assets:', err);
  process.exit(1);
});
