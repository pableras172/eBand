<?php

namespace Database\Seeders;

use App\Models\Actuacion;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\Contratos;
use App\Models\Instrument;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\Role;
use App\Models\Tipoactuacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Pobla el tenant de demostracion con datos realistas en fechas futuras.
     */
    public function run(): void
    {
        $instruments = $this->seedInstruments();
        $tipos = $this->seedTiposActuacion();
        $musicians = $this->seedMusicians($instruments);
        $contracts = $this->seedContracts();
        $actuaciones = $this->seedActuaciones($contracts, $tipos);

        $this->seedListasAndComments($actuaciones, $musicians);
        $this->seedAnnouncements($musicians);
        $this->seedInventory($musicians);
    }

    /**
     * Garantiza el catalogo basico de instrumentos.
     *
     * @return Collection<string, Instrument>
     */
    private function seedInstruments(): Collection
    {
        $catalog = [
            ['name' => 'Flauta', 'orden' => 1],
            ['name' => 'Clarinete', 'orden' => 2],
            ['name' => 'Saxo Alto', 'orden' => 3],
            ['name' => 'Saxo Tenor', 'orden' => 4],
            ['name' => 'Trompeta', 'orden' => 5],
            ['name' => 'Trombón', 'orden' => 6],
            ['name' => 'Tuba', 'orden' => 7],
            ['name' => 'Percusión', 'orden' => 8],
        ];

        return collect($catalog)->mapWithKeys(function (array $item): array {
            $instrument = Instrument::query()->firstOrCreate(
                ['name' => $item['name']],
                ['orden' => $item['orden']]
            );

            return [$item['name'] => $instrument];
        });
    }

    /**
     * Garantiza los tipos de actuacion necesarios para la demo.
     *
     * @return Collection<string, Tipoactuacion>
     */
    private function seedTiposActuacion(): Collection
    {
        $names = ['Ensayo', 'Pasacalle', 'Concierto', 'Entrada Mora', 'Entrada Cristiana', 'Procesión'];

        return collect($names)->mapWithKeys(function (string $name): array {
            $tipo = Tipoactuacion::query()->firstOrCreate(['nombre' => $name]);

            return [$name => $tipo];
        });
    }

    /**
     * Crea musicos ficticios sin modificar el usuario demo principal.
     *
     * @param  Collection<string, Instrument>  $instruments
     * @return Collection<int, User>
     */
    private function seedMusicians(Collection $instruments): Collection
    {
        $userRole = Role::query()->where('title', 'User')->first();
        $instrumentList = $instruments->values();

        $musiciansData = [
            ['name' => 'Lucía Navarro', 'email' => 'lucia.navarro@demo.eband.es', 'instrument' => 'Flauta', 'coche' => true, 'furgo' => false],
            ['name' => 'Carlos Martínez', 'email' => 'carlos.martinez@demo.eband.es', 'instrument' => 'Clarinete', 'coche' => true, 'furgo' => false],
            ['name' => 'Elena Serrano', 'email' => 'elena.serrano@demo.eband.es', 'instrument' => 'Clarinete', 'coche' => false, 'furgo' => false],
            ['name' => 'Javier Ruiz', 'email' => 'javier.ruiz@demo.eband.es', 'instrument' => 'Saxo Alto', 'coche' => true, 'furgo' => false],
            ['name' => 'Marta López', 'email' => 'marta.lopez@demo.eband.es', 'instrument' => 'Saxo Tenor', 'coche' => false, 'furgo' => false],
            ['name' => 'Alejandro Torres', 'email' => 'alejandro.torres@demo.eband.es', 'instrument' => 'Trompeta', 'coche' => true, 'furgo' => false],
            ['name' => 'Paula García', 'email' => 'paula.garcia@demo.eband.es', 'instrument' => 'Trompeta', 'coche' => false, 'furgo' => false],
            ['name' => 'David Moreno', 'email' => 'david.moreno@demo.eband.es', 'instrument' => 'Trombón', 'coche' => true, 'furgo' => true],
            ['name' => 'Sofía Jiménez', 'email' => 'sofia.jimenez@demo.eband.es', 'instrument' => 'Trombón', 'coche' => false, 'furgo' => false],
            ['name' => 'Pablo Gil', 'email' => 'pablo.gil@demo.eband.es', 'instrument' => 'Tuba', 'coche' => true, 'furgo' => false],
            ['name' => 'Hugo Sánchez', 'email' => 'hugo.sanchez@demo.eband.es', 'instrument' => 'Percusión', 'coche' => false, 'furgo' => true],
            ['name' => 'Carmen Vidal', 'email' => 'carmen.vidal@demo.eband.es', 'instrument' => 'Percusión', 'coche' => true, 'furgo' => false],
        ];

        $password = Hash::make('demo1234');

        return collect($musiciansData)->map(function (array $data, int $index) use ($instruments, $instrumentList, $userRole, $password): User {
            $instrumentId = $instruments->get($data['instrument'])?->id
                ?? $instrumentList->get($index % $instrumentList->count())->id;

            $user = User::query()->firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $password,
                    'instrument_id' => $instrumentId,
                    'telefono' => '600'.str_pad((string) (110000 + $index * 137), 6, '0', STR_PAD_LEFT),
                    'porcentaje' => 100,
                    'forastero' => false,
                    'activo' => true,
                    'fechaAlta' => now()->toDateString(),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'tienecoche' => $data['coche'],
                    'tienefurgo' => $data['furgo'],
                ]
            );

            if ($userRole && ! $user->roles()->where('roles.id', $userRole->id)->exists()) {
                $user->roles()->attach($userRole->id);
            }

            return $user;
        });
    }

    /**
     * Crea contratos futuros realistas.
     *
     * @return Collection<string, Contratos>
     */
    private function seedContracts(): Collection
    {
        $base = Carbon::now()->startOfDay();

        $contractsData = [
            [
                'key' => 'patronales',
                'poblacion' => 'Villalba del Monte',
                'fechainicio' => $base->copy()->addDays(10)->toDateString(),
                'fechafin' => $base->copy()->addDays(25)->toDateString(),
                'descripcion' => 'Fiestas Patronales de Villalba del Monte',
                'contacto' => 'Concejalía de Fiestas (Laura Méndez)',
                'telefono' => '960123456',
                'correo' => 'fiestas@villalbadelmonte.es',
                'anyo' => (int) $base->copy()->addDays(10)->year,
                'dnicontacto' => '00000001A',
                'observacions' => 'Incluye pasacalles matinal y concierto nocturno en plaza mayor.',
                'latitude' => 39.4699,
                'longitude' => -0.3763,
            ],
            [
                'key' => 'moros',
                'poblacion' => 'Alcolea de la Sierra',
                'fechainicio' => $base->copy()->addDays(32)->toDateString(),
                'fechafin' => $base->copy()->addDays(42)->toDateString(),
                'descripcion' => 'Desfiles de Moros y Cristianos - Comparsa Almogávares',
                'contacto' => 'Presidente Comparsa (Fernando Soler)',
                'telefono' => '965987654',
                'correo' => 'junta@almogavares-demo.es',
                'anyo' => (int) $base->copy()->addDays(32)->year,
                'dnicontacto' => '00000002B',
                'observacions' => 'Desfile de Entrada y retreta vespertina.',
                'latitude' => 38.6984,
                'longitude' => -0.4735,
            ],
            [
                'key' => 'auditorio',
                'poblacion' => 'San Vicente del Campo',
                'fechainicio' => $base->copy()->addDays(50)->toDateString(),
                'fechafin' => $base->copy()->addDays(65)->toDateString(),
                'descripcion' => 'Ciclo de Conciertos de Temporada - Auditorio Municipal',
                'contacto' => 'Dirección Cultural (Beatriz Pardo)',
                'telefono' => '962456789',
                'correo' => 'auditorio@sanvicente-demo.es',
                'anyo' => (int) $base->copy()->addDays(50)->year,
                'dnicontacto' => '00000003C',
                'observacions' => 'Prueba acústica 90 minutos antes del concierto.',
                'latitude' => 39.5120,
                'longitude' => -0.4160,
            ],
            [
                'key' => 'hermandad',
                'poblacion' => 'Torreblanca Alta',
                'fechainicio' => $base->copy()->addDays(75)->toDateString(),
                'fechafin' => $base->copy()->addDays(95)->toDateString(),
                'descripcion' => 'Procesiones y Actos de Primavera',
                'contacto' => 'Hermandad Mayor (Manuel Domínguez)',
                'telefono' => '964321654',
                'correo' => 'secretaria@hermandad-demo.es',
                'anyo' => (int) $base->copy()->addDays(75)->year,
                'dnicontacto' => '00000004D',
                'observacions' => 'Uniforme de gala completo.',
                'latitude' => 39.9864,
                'longitude' => -0.0513,
            ],
        ];

        return collect($contractsData)->mapWithKeys(function (array $data): array {
            $key = $data['key'];
            unset($data['key']);

            $contrato = Contratos::query()->firstOrCreate(
                ['descripcion' => $data['descripcion']],
                $data
            );

            return [$key => $contrato];
        });
    }

    /**
     * Crea ensayos y actuaciones futuras.
     *
     * @param  Collection<string, Contratos>  $contracts
     * @param  Collection<string, Tipoactuacion>  $tipos
     * @return Collection<int, Actuacion>
     */
    private function seedActuaciones(Collection $contracts, Collection $tipos): Collection
    {
        $base = Carbon::now()->startOfDay();

        $events = [
            [
                'days' => 2,
                'hour' => '20:30',
                'descripcion' => 'Ensayo general repertorio Fiestas Patronales',
                'tipo' => 'Ensayo',
                'contrato' => 'patronales',
                'coches' => 0,
                'preciocoche' => 0,
                'musicos' => 24,
                'preciomusico' => 0,
                'observaciones' => 'Traer partituras nuevas de pasodobles.',
            ],
            [
                'days' => 6,
                'hour' => '19:30',
                'descripcion' => 'Ensayo parcial sección viento-madera y percusión',
                'tipo' => 'Ensayo',
                'contrato' => 'patronales',
                'coches' => 0,
                'preciocoche' => 0,
                'musicos' => 14,
                'preciomusico' => 0,
                'observaciones' => 'Repaso de tempi y dinámicas en la sala B.',
            ],
            [
                'days' => 12,
                'hour' => '11:00',
                'descripcion' => 'Pasacalles inaugural Fiestas de Villalba',
                'tipo' => 'Pasacalle',
                'contrato' => 'patronales',
                'coches' => 5,
                'preciocoche' => 20,
                'musicos' => 22,
                'preciomusico' => 45,
                'observaciones' => 'Concentración a las 10:30 en Plaza del Ayuntamiento.',
            ],
            [
                'days' => 14,
                'hour' => '21:00',
                'descripcion' => 'Concierto nocturno en Plaza Mayor',
                'tipo' => 'Concierto',
                'contrato' => 'patronales',
                'coches' => 6,
                'preciocoche' => 20,
                'musicos' => 26,
                'preciomusico' => 65,
                'observaciones' => 'Habrá sillas y atriles en el escenario.',
            ],
            [
                'days' => 28,
                'hour' => '20:00',
                'descripcion' => 'Ensayo marchas moras y cristianas',
                'tipo' => 'Ensayo',
                'contrato' => 'moros',
                'coches' => 0,
                'preciocoche' => 0,
                'musicos' => 25,
                'preciomusico' => 0,
                'observaciones' => 'Ensayo con formación de desfile en el patio.',
            ],
            [
                'days' => 35,
                'hour' => '17:30',
                'descripcion' => 'Entrada Cristiana - Comparsa Almogávares',
                'tipo' => 'Entrada Cristiana',
                'contrato' => 'moros',
                'coches' => 7,
                'preciocoche' => 25,
                'musicos' => 28,
                'preciomusico' => 80,
                'observaciones' => 'Salida puntual desde Avenida del Castillo.',
            ],
            [
                'days' => 38,
                'hour' => '18:00',
                'descripcion' => 'Entrada Mora - Desfile vespertino',
                'tipo' => 'Entrada Mora',
                'contrato' => 'moros',
                'coches' => 7,
                'preciocoche' => 25,
                'musicos' => 28,
                'preciomusico' => 80,
                'observaciones' => 'Incluye cena de hermandad al finalizar.',
            ],
            [
                'days' => 56,
                'hour' => '19:00',
                'descripcion' => 'Concierto de Temporada en Auditorio Municipal',
                'tipo' => 'Concierto',
                'contrato' => 'auditorio',
                'coches' => 6,
                'preciocoche' => 22,
                'musicos' => 30,
                'preciomusico' => 75,
                'observaciones' => 'Prueba de sonido a las 17:30. Traje negro completo.',
            ],
            [
                'days' => 82,
                'hour' => '20:00',
                'descripcion' => 'Procesión Solemne de Primavera',
                'tipo' => 'Procesión',
                'contrato' => 'hermandad',
                'coches' => 6,
                'preciocoche' => 24,
                'musicos' => 26,
                'preciomusico' => 70,
                'observaciones' => 'Recorrido de 2 horas por el casco antiguo.',
            ],
        ];

        return collect($events)->map(function (array $event) use ($base, $contracts, $tipos): Actuacion {
            $fecha = $base->copy()->addDays($event['days'])->format('Y-m-d').' '.$event['hour'].':00';
            $totalCoches = $event['coches'] * $event['preciocoche'];
            $totalMusicos = $event['musicos'] * $event['preciomusico'];

            return Actuacion::query()->firstOrCreate(
                ['descripcion' => $event['descripcion']],
                [
                    'fechaActuacion' => $fecha,
                    'tipoactuacions_id' => $tipos->get($event['tipo'])->id,
                    'contratos_id' => $contracts->get($event['contrato'])->id,
                    'coches' => $event['coches'],
                    'preciocoche' => $event['preciocoche'],
                    'musicos' => $event['musicos'],
                    'preciomusico' => $event['preciomusico'],
                    'totalcoches' => $totalCoches,
                    'totalmusicos' => $totalMusicos,
                    'totalactuacion' => $totalCoches + $totalMusicos,
                    'pagado' => false,
                    'aplicaporcentaje' => false,
                    'noaplicapago' => $event['tipo'] === 'Ensayo',
                    'is_draft' => false,
                    'observaciones' => $event['observaciones'],
                ]
            );
        });
    }

    /**
     * Crea listas de asistencia y comentarios de coordinacion para las actuaciones futuras.
     *
     * @param  Collection<int, Actuacion>  $actuaciones
     * @param  Collection<int, User>  $musicians
     */
    private function seedListasAndComments(Collection $actuaciones, Collection $musicians): void
    {
        $sampleComments = [
            'Recordad llevar atril portátil y pinzas para las partituras.',
            'Salimos 30 minutos antes desde el local para aparcar sin prisas.',
            'Confirmado que habrá agua y zona para guardar fundas cerca del escenario.',
            'Por favor, revisad los compases finales del segundo pasodoble antes del ensayo.',
        ];

        foreach ($actuaciones as $index => $actuacion) {
            $lista = Listas::query()->firstOrCreate(
                ['actuacions_id' => $actuacion->id],
                [
                    'pagada' => false,
                    'cuentas' => false,
                ]
            );

            if (! ListasUser::query()->where('listas_id', $lista->id)->exists()) {
                $assigned = $musicians->slice(0, min(8, $musicians->count()));
                foreach ($assigned as $musicianIndex => $musician) {
                    ListasUser::query()->create([
                        'listas_id' => $lista->id,
                        'user_id' => $musician->id,
                        'coche' => $musician->tienecoche && $musicianIndex < 4,
                        'pagada' => false,
                        'cuentas' => false,
                    ]);
                }
            }

            if (! Comment::query()->where('actuacion_id', $actuacion->id)->exists() && $musicians->isNotEmpty()) {
                $author = $musicians->get($index % $musicians->count());
                Comment::query()->create([
                    'comment' => $sampleComments[$index % count($sampleComments)],
                    'inadecuado' => false,
                    'eliminado' => false,
                    'user_id' => $author->id,
                    'actuacion_id' => $actuacion->id,
                    'data' => json_encode(['from_device' => 'ios']),
                ]);
            }
        }
    }

    /**
     * Crea anuncios activos visibles durante las proximas semanas.
     *
     * @param  Collection<int, User>  $musicians
     */
    private function seedAnnouncements(Collection $musicians): void
    {
        $creatorId = User::query()->value('id') ?? $musicians->first()?->id;

        $announcements = [
            [
                'title' => 'Calendario de ensayos y actuaciones actualizado',
                'body' => 'Ya podéis consultar en el calendario las próximas salidas de fiestas, conciertos de temporada y ensayos generales.',
            ],
            [
                'title' => 'Confirmación de asistencia y vehículos',
                'body' => 'Por favor, confirmad con antelación vuestra disponibilidad y si podéis llevar coche para organizar los desplazamientos.',
            ],
        ];

        foreach ($announcements as $item) {
            Announcement::query()->firstOrCreate(
                ['title' => $item['title']],
                [
                    'body' => $item['body'],
                    'content_view' => null,
                    'redirect_url' => null,
                    'starts_at' => now(),
                    'ends_at' => now()->addDays(60),
                    'is_active' => true,
                    'applies_to_all' => true,
                    'created_by' => $creatorId,
                    'notified_at' => null,
                ]
            );
        }
    }

    /**
     * Crea categorias e items de inventario de ejemplo si no existen.
     *
     * @param  Collection<int, User>  $musicians
     */
    private function seedInventory(Collection $musicians): void
    {
        $viento = InventoryCategory::query()->firstOrCreate(['nombre' => 'Instrumentos de viento']);
        $percusion = InventoryCategory::query()->firstOrCreate(['nombre' => 'Percusión y escenario']);

        $items = [
            ['category' => $viento->id, 'nombre' => 'Tuba Sib Yamaha YBB-321', 'cantidad' => 2, 'valor' => 3850.00, 'estado' => 'bueno'],
            ['category' => $viento->id, 'nombre' => 'Saxofón Barítono Jupiter', 'cantidad' => 1, 'valor' => 2600.00, 'estado' => 'bueno'],
            ['category' => $viento->id, 'nombre' => 'Trombón de varas Bach', 'cantidad' => 3, 'valor' => 1150.00, 'estado' => 'bueno'],
            ['category' => $percusion->id, 'nombre' => 'Bombo de concierto 36"', 'cantidad' => 1, 'valor' => 1450.00, 'estado' => 'bueno'],
            ['category' => $percusion->id, 'nombre' => 'Juego de platos Zildjian 18"', 'cantidad' => 2, 'valor' => 480.00, 'estado' => 'bueno'],
            ['category' => $percusion->id, 'nombre' => 'Atriles metálicos plegables', 'cantidad' => 30, 'valor' => 35.00, 'estado' => 'bueno'],
        ];

        $responsableId = $musicians->first()?->id;

        foreach ($items as $item) {
            $record = InventoryItem::query()->firstOrCreate(
                ['nombre' => $item['nombre']],
                [
                    'inventory_category_id' => $item['category'],
                    'year' => now()->year,
                    'cantidad' => $item['cantidad'],
                    'valor_unitario' => $item['valor'],
                    'estado' => $item['estado'],
                    'observaciones' => 'Material propiedad de la agrupación (datos demo).',
                    'depreciation_rate' => 5.00,
                    'purchase_date' => now()->subMonths(6)->toDateString(),
                ]
            );

            if ($responsableId && ! $record->responsables()->where('users.id', $responsableId)->exists()) {
                $record->responsables()->attach($responsableId);
            }
        }
    }
}
