<div
	wire:ignore
	id="map"
	class="w-full rounded-xl border"
    style="height: {{ $height }}px;"
	data-municipios='@json($municipios ?? [])'>
</div>
<style>
	 /* Contain Leaflet z-indexes inside the map stacking context so they
		 don't bleed over modals/popups rendered outside the map container */
	 #map .leaflet-tile-pane     { z-index: 2; }
	 #map .leaflet-shadow-pane   { z-index: 5; }
	 #map .leaflet-overlay-pane  { z-index: 4; }
	 #map .leaflet-marker-pane   { z-index: 6; }
	 #map .leaflet-tooltip-pane  { z-index: 7; }
	 #map .leaflet-popup-pane    { z-index: 8; }
	 #map .leaflet-top,
	 #map .leaflet-bottom        { z-index: 10; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
	// Leer municipios iniciales (si los hay) desde el atributo data-
	const mapEl = document.getElementById('map');
	const initialMunicipios = JSON.parse(mapEl.dataset.municipios || '[]');

	// Crear mapa
	const map = L.map('map'); // se ajustará con fitBounds o vista por defecto
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; OpenStreetMap'
	}).addTo(map);

	// Grupo de marcadores
	const markersGroup = L.featureGroup().addTo(map);

	// Icono personalizado por usuario (instrumento) con fallback al logo
	const markerIconUrl = @json(
		(optional(Auth::user()->instrument)->icon
			? asset('storage/imagenes/instruments/' . Auth::user()->instrument->icon)
			: URL::to('/') . '/imagenes/logo.png')
	);
	const markerIcon = L.icon({
		iconUrl: markerIconUrl,
		iconSize: [48, 48],
		iconAnchor: [24, 48],
		popupAnchor: [0, -28],
		className: 'custom-marker'
	});

	// Helpers
	function popupHtml(nombre, texto = '') {
		return `
			<div style="min-width:180px;">
				<div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
					<img src="${markerIconUrl}" alt="icon" style="width:20px;height:20px;border-radius:4px;">
					<strong>${nombre}</strong>
				</div>
				${texto ? `<p style="font-size:12px;color:#333;margin:0 0 6px;">${texto}</p>` : ''}
			</div>
		`;
	}

function fitView() {
    if (markersGroup.getLayers().length) {
        map.fitBounds(markersGroup.getBounds(), {
            padding: [20, 20],
            maxZoom: 13   // 👈 límite de zoom
        });
    } else {
        map.setView([39.5, -0.4], 8);
    }
}


	function addMarker(nombre, coords, texto) {
		const m = L.marker(coords, { icon: markerIcon }).bindPopup(popupHtml(nombre, texto));
		markersGroup.addLayer(m);
	}

	async function geocodeMunicipio(nombre) {
		const q = encodeURIComponent(nombre);
		const url = `https://nominatim.openstreetmap.org/search?format=json&q=${q}`;
		const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
		if (!res.ok) throw new Error('Geocoding failed');
		const data = await res.json();
		if (!Array.isArray(data) || data.length === 0) throw new Error('No results');
		return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
	}

	async function addMunicipio(item) {
		const nombre = item?.nombre || '';
		const texto = item?.texto || '';
        
		let coords = item?.coords;

		try {
			if (!coords || coords.length !== 2) {
				coords = await geocodeMunicipio(nombre);
			}
			addMarker(nombre, coords, texto);
			fitView();
		} catch (e) {
			console.warn('No se pudo añadir el municipio', nombre, e);
		}
	}

	async function setMunicipios(items) {
		clearMarkers();
		for (const it of (items || [])) {
			await addMunicipio(it);
		}
		fitView();
	}

	function clearMarkers() {
		markersGroup.clearLayers();
	}

	// Inicializar con municipios (si se pasaron desde backend)
	if (Array.isArray(initialMunicipios) && initialMunicipios.length > 0) {
		setMunicipios(initialMunicipios);
	} else {
		fitView();
	}

	// API pública del componente (útil desde formularios u otras vistas)
	window.MapComponent = {
		addMunicipio, setMunicipios, clear: clearMarkers
	};

	// Soporte vía eventos del navegador
	window.addEventListener('location-map:add', (e) => {
		if (e.detail) addMunicipio(e.detail);
	});
	window.addEventListener('location-map:set', (e) => {
		if (e.detail) setMunicipios(e.detail);
	});
});
</script>
