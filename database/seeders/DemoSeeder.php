<?php

namespace Database\Seeders;

use App\Models\Actuacion;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\ConcertProgram;
use App\Models\Contratos;
use App\Models\Instrument;
use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\Payment;
use App\Models\Paymentresume;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\Tipoactuacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Puebla la base de datos de demostración con músicos famosos, instrumentos,
     * actuaciones, listas de asistencia, liquidaciones de pago, programas de concierto,
     * comentarios, anuncios e inventario.
     */
    public function run(): void
    {
        // Asegurar que el tenant demo esté inicializado si se ejecuta aisladamente
        if (function_exists('tenancy') && ! tenancy()->initialized) {
            $tenant = Tenant::find('demo') ?? Tenant::first();
            if ($tenant) {
                tenancy()->initialize($tenant);
            }
        }

        $roles = $this->seedRoles();
        $instruments = $this->seedInstruments();
        $tipos = $this->seedTiposActuacion();
        $musicians = $this->seedFamousMusicians($instruments, $roles);
        $contracts = $this->seedContracts();
        $actuaciones = $this->seedActuaciones($contracts, $tipos);

        $this->seedListasAndAsistencias($actuaciones, $musicians);
        $this->seedPayments($musicians, $actuaciones);
        $this->seedConcertPrograms();
        $this->seedComments($actuaciones, $musicians);
        $this->seedAnnouncements($musicians);
        $this->seedInventory($musicians);

        $this->command?->info('¡Base de datos demo completada con éxito con grandes músicos famosos!');
    }

    /**
     * Garantiza los roles básicos del sistema (Admin y User).
     *
     * @return array{admin: Role, user: Role}
     */
    private function seedRoles(): array
    {
        $admin = Role::query()->firstOrCreate(['title' => 'Admin'], ['title' => 'Admin']);
        $user = Role::query()->firstOrCreate(['title' => 'User'], ['title' => 'User']);

        return ['admin' => $admin, 'user' => $user];
    }

    /**
     * Catálogo completo de instrumental para banda de música.
     *
     * @return Collection<string, Instrument>
     */
    private function seedInstruments(): Collection
    {
        $catalog = [
            ['name' => 'Flauta', 'orden' => 1],
            ['name' => 'Oboe', 'orden' => 2],
            ['name' => 'Clarinete', 'orden' => 3],
            ['name' => 'Fagot', 'orden' => 4],
            ['name' => 'Saxo Alto', 'orden' => 5],
            ['name' => 'Saxo Tenor', 'orden' => 6],
            ['name' => 'Saxo Barítono', 'orden' => 7],
            ['name' => 'Trompeta', 'orden' => 8],
            ['name' => 'Trompa', 'orden' => 9],
            ['name' => 'Trombón', 'orden' => 10],
            ['name' => 'Bombardino', 'orden' => 11],
            ['name' => 'Tuba', 'orden' => 12],
            ['name' => 'Percusión', 'orden' => 13],
            ['name' => 'Piano / Teclados', 'orden' => 14],
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
     * Tipos de actuación tradicionales para bandas, comparsas y conciertos.
     *
     * @return Collection<string, Tipoactuacion>
     */
    private function seedTiposActuacion(): Collection
    {
        $names = [
            'Ensayo',
            'Pasacalle',
            'Concierto',
            'Entrada Mora',
            'Entrada Cristiana',
            'Procesión',
            'Concierto Extraordinario',
        ];

        return collect($names)->mapWithKeys(function (string $name): array {
            $tipo = Tipoactuacion::query()->firstOrCreate(['nombre' => $name]);

            return [$name => $tipo];
        });
    }

    /**
     * Registra grandes músicos famosos como miembros de la banda.
     * Los directores y jefes de cuerda tienen rol Admin; el resto rol User.
     *
     * @param  Collection<string, Instrument>  $instruments
     * @param  array{admin: Role, user: Role}  $roles
     * @return Collection<int, User>
     */
    private function seedFamousMusicians(Collection $instruments, array $roles): Collection
    {
        $password = Hash::make('demo1234');

        $musiciansData = [
            // DIRECTORES Y ADMINISTRADORES (ADMIN)
            [
                'name' => 'Ludwig van Beethoven',
                'email' => 'admin@eband.app', // Usuario principal del autologin demo
                'instrument' => 'Trombón',
                'role' => 'admin',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600100001',
            ],
            [
                'name' => 'Wolfgang Amadeus Mozart',
                'email' => 'mozart@demo.eband.app',
                'instrument' => 'Clarinete',
                'role' => 'admin',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600100002',
            ],
            [
                'name' => 'Johann Sebastian Bach',
                'email' => 'bach@demo.eband.app',
                'instrument' => 'Piano / Teclados',
                'role' => 'admin',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600100003',
            ],
            [
                'name' => 'Miles Davis',
                'email' => 'miles.davis@demo.eband.app',
                'instrument' => 'Trompeta',
                'role' => 'admin',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600100004',
            ],
            [
                'name' => 'Ennio Morricone',
                'email' => 'morricone@demo.eband.app',
                'instrument' => 'Trompeta',
                'role' => 'admin',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600100005',
            ],

            // SECCIÓN DE FLAUTAS (USER)
            [
                'name' => 'Antonio Vivaldi',
                'email' => 'vivaldi@demo.eband.app',
                'instrument' => 'Flauta',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200001',
            ],
            [
                'name' => 'Claude Debussy',
                'email' => 'debussy@demo.eband.app',
                'instrument' => 'Flauta',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200002',
            ],
            [
                'name' => 'Pyotr Ilyich Tchaikovsky',
                'email' => 'tchaikovsky@demo.eband.app',
                'instrument' => 'Flauta',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200003',
            ],
            [
                'name' => 'Montserrat Caballé',
                'email' => 'caballe@demo.eband.app',
                'instrument' => 'Flauta',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200004',
            ],

            // SECCIÓN DE OBOES Y FAGOTES (USER)
            [
                'name' => 'Maria Callas',
                'email' => 'callas@demo.eband.app',
                'instrument' => 'Oboe',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200005',
            ],
            [
                'name' => 'Georg Philipp Telemann',
                'email' => 'telemann@demo.eband.app',
                'instrument' => 'Oboe',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200006',
            ],
            [
                'name' => 'Franz Liszt',
                'email' => 'liszt@demo.eband.app',
                'instrument' => 'Fagot',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200007',
            ],

            // SECCIÓN DE CLARINETES (USER)
            [
                'name' => 'Benny Goodman',
                'email' => 'goodman@demo.eband.app',
                'instrument' => 'Clarinete',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200008',
            ],
            [
                'name' => 'George Gershwin',
                'email' => 'gershwin@demo.eband.app',
                'instrument' => 'Clarinete',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200009',
            ],
            [
                'name' => 'Igor Stravinsky',
                'email' => 'stravinsky@demo.eband.app',
                'instrument' => 'Clarinete',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 80,
                'telefono' => '600200010',
            ],
            [
                'name' => 'John Lennon',
                'email' => 'lennon@demo.eband.app',
                'instrument' => 'Clarinete',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200011',
            ],

            // SECCIÓN DE SAXOFONES (USER)
            [
                'name' => 'Charlie Parker',
                'email' => 'parker@demo.eband.app',
                'instrument' => 'Saxo Alto',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200012',
            ],
            [
                'name' => 'David Bowie',
                'email' => 'bowie@demo.eband.app',
                'instrument' => 'Saxo Alto',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200013',
            ],
            [
                'name' => 'Astor Piazzolla',
                'email' => 'piazzolla@demo.eband.app',
                'instrument' => 'Saxo Alto',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200014',
            ],
            [
                'name' => 'John Coltrane',
                'email' => 'coltrane@demo.eband.app',
                'instrument' => 'Saxo Tenor',
                'role' => 'user',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600200015',
            ],
            [
                'name' => 'Wayne Shorter',
                'email' => 'shorter@demo.eband.app',
                'instrument' => 'Saxo Tenor',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200016',
            ],
            [
                'name' => 'Sonny Rollins',
                'email' => 'rollins@demo.eband.app',
                'instrument' => 'Saxo Barítono',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200017',
            ],

            // SECCIÓN DE TROMPETAS (USER)
            [
                'name' => 'Louis Armstrong',
                'email' => 'armstrong@demo.eband.app',
                'instrument' => 'Trompeta',
                'role' => 'user',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600200018',
            ],
            [
                'name' => 'Dizzy Gillespie',
                'email' => 'gillespie@demo.eband.app',
                'instrument' => 'Trompeta',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200019',
            ],
            [
                'name' => 'Chet Baker',
                'email' => 'baker@demo.eband.app',
                'instrument' => 'Trompeta',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 80,
                'telefono' => '600200020',
            ],
            [
                'name' => 'Wynton Marsalis',
                'email' => 'marsalis@demo.eband.app',
                'instrument' => 'Trompeta',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200021',
            ],

            // SECCIÓN DE TROMBONES Y BOMBARDINOS (USER)
            [
                'name' => 'Giuseppe Verdi',
                'email' => 'verdi@demo.eband.app',
                'instrument' => 'Trombón',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200022',
            ],
            [
                'name' => 'Glenn Miller',
                'email' => 'miller@demo.eband.app',
                'instrument' => 'Trombón',
                'role' => 'user',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600200023',
            ],
            [
                'name' => 'Tommy Dorsey',
                'email' => 'dorsey@demo.eband.app',
                'instrument' => 'Trombón',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200024',
            ],
            [
                'name' => 'Johannes Brahms',
                'email' => 'brahms@demo.eband.app',
                'instrument' => 'Bombardino',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200025',
            ],

            // SECCIÓN DE TUBAS (USER)
            [
                'name' => 'Gustav Mahler',
                'email' => 'mahler@demo.eband.app',
                'instrument' => 'Tuba',
                'role' => 'user',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600200026',
            ],
            [
                'name' => 'Richard Wagner',
                'email' => 'wagner@demo.eband.app',
                'instrument' => 'Tuba',
                'role' => 'user',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600200027',
            ],
            [
                'name' => 'Jaco Pastorius',
                'email' => 'pastorius@demo.eband.app',
                'instrument' => 'Tuba',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200028',
            ],

            // SECCIÓN DE PERCUSIÓN Y BATERÍA (USER)
            [
                'name' => 'Maurice Ravel',
                'email' => 'ravel@demo.eband.app',
                'instrument' => 'Percusión',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200029',
            ],
            [
                'name' => 'Buddy Rich',
                'email' => 'rich@demo.eband.app',
                'instrument' => 'Percusión',
                'role' => 'user',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600200030',
            ],
            [
                'name' => 'Tito Puente',
                'email' => 'puente@demo.eband.app',
                'instrument' => 'Percusión',
                'role' => 'user',
                'coche' => true,
                'furgo' => true,
                'porcentaje' => 100,
                'telefono' => '600200031',
            ],
            [
                'name' => 'Freddie Mercury',
                'email' => 'mercury@demo.eband.app',
                'instrument' => 'Percusión',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200032',
            ],
            [
                'name' => 'Carlos Santana',
                'email' => 'santana@demo.eband.app',
                'instrument' => 'Percusión',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200033',
            ],
            [
                'name' => 'Ringo Starr',
                'email' => 'starr@demo.eband.app',
                'instrument' => 'Percusión',
                'role' => 'user',
                'coche' => false,
                'furgo' => true,
                'porcentaje' => 80,
                'telefono' => '600200034',
            ],

            // SECCIÓN DE PIANO Y TECLADOS (USER)
            [
                'name' => 'Duke Ellington',
                'email' => 'ellington@demo.eband.app',
                'instrument' => 'Piano / Teclados',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200035',
            ],
            [
                'name' => 'Stevie Wonder',
                'email' => 'wonder@demo.eband.app',
                'instrument' => 'Piano / Teclados',
                'role' => 'user',
                'coche' => false,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200036',
            ],
            [
                'name' => 'Aretha Franklin',
                'email' => 'franklin@demo.eband.app',
                'instrument' => 'Piano / Teclados',
                'role' => 'user',
                'coche' => true,
                'furgo' => false,
                'porcentaje' => 100,
                'telefono' => '600200037',
            ],
        ];

        return collect($musiciansData)->map(function (array $data) use ($instruments, $roles, $password): User {
            $instrumentId = $instruments->get($data['instrument'])?->id
                ?? $instruments->first()?->id;

            $user = User::query()->where('email', $data['email'])->first();
            if ($user) {
                $user->update([
                    'name' => $data['name'],
                    'instrument_id' => $instrumentId,
                    'telefono' => $data['telefono'],
                    'porcentaje' => $data['porcentaje'],
                    'tienecoche' => $data['coche'],
                    'tienefurgo' => $data['furgo'],
                    'activo' => true,
                ]);
            } else {
                $user = User::query()->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $password,
                    'instrument_id' => $instrumentId,
                    'telefono' => $data['telefono'],
                    'porcentaje' => $data['porcentaje'],
                    'forastero' => false,
                    'activo' => true,
                    'fechaAlta' => now()->subYears(2)->toDateString(),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'tienecoche' => $data['coche'],
                    'tienefurgo' => $data['furgo'],
                ]);
            }

            // Asignar rol Admin o User
            if ($data['role'] === 'admin') {
                $user->roles()->syncWithoutDetaching([$roles['admin']->id]);
            } else {
                $user->roles()->syncWithoutDetaching([$roles['user']->id]);
            }

            return $user;
        });
    }

    /**
     * Crea contratos representativos en distintas poblaciones.
     *
     * @return Collection<string, Contratos>
     */
    private function seedContracts(): Collection
    {
        $base = Carbon::now()->startOfDay();

        $contractsData = [
            [
                'key' => 'villalba',
                'poblacion' => 'Villalba del Monte',
                'fechainicio' => $base->copy()->subMonths(3)->toDateString(),
                'fechafin' => $base->copy()->subMonths(2)->toDateString(),
                'descripcion' => 'Fiestas Patronales de Villalba del Monte 2026',
                'contacto' => 'Concejalía de Fiestas (Laura Méndez)',
                'telefono' => '960123456',
                'correo' => 'fiestas@villalbadelmonte.es',
                'anyo' => (int) $base->year,
                'dnicontacto' => '00000001A',
                'observacions' => 'Pasacalles matinales, conciertos en plaza mayor y procesión.',
                'latitude' => 39.4699,
                'longitude' => -0.3763,
            ],
            [
                'key' => 'alcolea',
                'poblacion' => 'Alcolea de la Sierra',
                'fechainicio' => $base->copy()->subMonths(2)->toDateString(),
                'fechafin' => $base->copy()->subMonths(1)->toDateString(),
                'descripcion' => 'Fiestas de Moros y Cristianos de Alcolea 2026',
                'contacto' => 'Junta Central de Comparsas (Fernando Soler)',
                'telefono' => '965987654',
                'correo' => 'junta@alcolea-demo.es',
                'anyo' => (int) $base->year,
                'dnicontacto' => '00000002B',
                'observacions' => 'Desfiles de Entrada Mora, Entrada Cristiana y retreta.',
                'latitude' => 38.6984,
                'longitude' => -0.4735,
            ],
            [
                'key' => 'sanvicente',
                'poblacion' => 'San Vicente del Campo',
                'fechainicio' => $base->copy()->subMonth()->toDateString(),
                'fechafin' => $base->copy()->addMonths(1)->toDateString(),
                'descripcion' => 'Ciclo de Conciertos de Temporada - Auditorio Municipal',
                'contacto' => 'Dirección Cultural (Beatriz Pardo)',
                'telefono' => '962456789',
                'correo' => 'auditorio@sanvicente-demo.es',
                'anyo' => (int) $base->year,
                'dnicontacto' => '00000003C',
                'observacions' => 'Conciertos de primavera y Santa Cecilia con acústica sinfónica.',
                'latitude' => 39.5120,
                'longitude' => -0.4160,
            ],
            [
                'key' => 'torreblanca',
                'poblacion' => 'Torreblanca Alta',
                'fechainicio' => $base->copy()->addDays(5)->toDateString(),
                'fechafin' => $base->copy()->addDays(45)->toDateString(),
                'descripcion' => 'Semana Grande y Procesiones de Primavera de Torreblanca',
                'contacto' => 'Hermandad de Cofradías (Manuel Domínguez)',
                'telefono' => '964321654',
                'correo' => 'secretaria@hermandad-demo.es',
                'anyo' => (int) $base->year,
                'dnicontacto' => '00000004D',
                'observacions' => 'Uniforme de gala completo. Marchas de procesión lentas.',
                'latitude' => 39.9864,
                'longitude' => -0.0513,
            ],
            [
                'key' => 'montaverner',
                'poblacion' => 'Montaverner',
                'fechainicio' => $base->copy()->addDays(30)->toDateString(),
                'fechafin' => $base->copy()->addDays(70)->toDateString(),
                'descripcion' => 'Festes Patronals i de Moros i Cristians de Montaverner',
                'contacto' => 'Comissió de Festes (Vicent Bataller)',
                'telefono' => '962297001',
                'correo' => 'festes@montaverner.es',
                'anyo' => (int) $base->year,
                'dnicontacto' => '00000005E',
                'observacions' => 'Participació completa en dianes, cercaviles i entrades.',
                'latitude' => 38.8893,
                'longitude' => -0.4975,
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
     * Registra actuaciones pasadas (para liquidaciones e historial) y futuras (para calendario y asistencia).
     *
     * @param  Collection<string, Contratos>  $contracts
     * @param  Collection<string, Tipoactuacion>  $tipos
     * @return Collection<int, Actuacion>
     */
    private function seedActuaciones(Collection $contracts, Collection $tipos): Collection
    {
        $base = Carbon::now()->startOfDay();

        $events = [
            // ACTUACIONES PASADAS (Año actual - 3 meses a -1 mes)
            [
                'date' => $base->copy()->subDays(80)->setTime(20, 0),
                'descripcion' => 'Ensayo general repertorio de Fiestas de Villalba',
                'tipo' => 'Ensayo',
                'contrato' => 'villalba',
                'coches' => 0,
                'preciocoche' => 0,
                'musicos' => 30,
                'preciomusico' => 0,
                'noaplicapago' => 1,
                'pagado' => 0,
                'observaciones' => 'Ensayo general en el salón de la sociedad.',
            ],
            [
                'date' => $base->copy()->subDays(72)->setTime(11, 30),
                'descripcion' => 'Pasacalles matinal de Fiestas Patronales',
                'tipo' => 'Pasacalle',
                'contrato' => 'villalba',
                'coches' => 8,
                'preciocoche' => 20,
                'musicos' => 28,
                'preciomusico' => 45,
                'noaplicapago' => 0,
                'pagado' => 1,
                'observaciones' => 'Pasacalles festivo y recogida de festeros.',
            ],
            [
                'date' => $base->copy()->subDays(70)->setTime(22, 0),
                'descripcion' => 'Gran Concierto de Gala en Plaza Mayor',
                'tipo' => 'Concierto',
                'contrato' => 'villalba',
                'coches' => 8,
                'preciocoche' => 20,
                'musicos' => 32,
                'preciomusico' => 70,
                'noaplicapago' => 0,
                'pagado' => 1,
                'observaciones' => 'Concierto sinfónico nocturno al aire libre.',
            ],
            [
                'date' => $base->copy()->subDays(50)->setTime(20, 30),
                'descripcion' => 'Ensayo de marchas moras y cristianas de Alcolea',
                'tipo' => 'Ensayo',
                'contrato' => 'alcolea',
                'coches' => 0,
                'preciocoche' => 0,
                'musicos' => 30,
                'preciomusico' => 0,
                'noaplicapago' => 1,
                'pagado' => 0,
                'observaciones' => 'Ensayo rítmico y de cuadratura de desfile.',
            ],
            [
                'date' => $base->copy()->subDays(42)->setTime(18, 0),
                'descripcion' => 'Desfile de Entrada Cristiana de Alcolea',
                'tipo' => 'Entrada Cristiana',
                'contrato' => 'alcolea',
                'coches' => 9,
                'preciocoche' => 25,
                'musicos' => 30,
                'preciomusico' => 85,
                'noaplicapago' => 0,
                'pagado' => 1,
                'observaciones' => 'Desfile oficial con la Filà Cristiana capitana.',
            ],
            [
                'date' => $base->copy()->subDays(40)->setTime(18, 30),
                'descripcion' => 'Desfile de Entrada Mora de Alcolea',
                'tipo' => 'Entrada Mora',
                'contrato' => 'alcolea',
                'coches' => 9,
                'preciocoche' => 25,
                'musicos' => 30,
                'preciomusico' => 85,
                'noaplicapago' => 0,
                'pagado' => 1,
                'observaciones' => 'Marchas moras solemnes con gran percusión.',
            ],
            [
                'date' => $base->copy()->subDays(20)->setTime(19, 30),
                'descripcion' => 'Concierto de Temporada en Auditorio San Vicente',
                'tipo' => 'Concierto',
                'contrato' => 'sanvicente',
                'coches' => 7,
                'preciocoche' => 20,
                'musicos' => 32,
                'preciomusico' => 75,
                'noaplicapago' => 0,
                'pagado' => 1,
                'observaciones' => 'Ciclo de auditorio municipal.',
            ],

            // ACTUACIONES PRÓXIMAS Y FUTURAS (Días siguientes)
            [
                'date' => $base->copy()->addDays(4)->setTime(20, 0),
                'descripcion' => 'Ensayo general repertorio de Semana Santa',
                'tipo' => 'Ensayo',
                'contrato' => 'torreblanca',
                'coches' => 0,
                'preciocoche' => 0,
                'musicos' => 28,
                'preciomusico' => 0,
                'noaplicapago' => 1,
                'pagado' => 0,
                'observaciones' => 'Repaso de marchas de procesión fúnebres y solemnes.',
            ],
            [
                'date' => $base->copy()->addDays(12)->setTime(19, 0),
                'descripcion' => 'Procesión del Silencio de Torreblanca',
                'tipo' => 'Procesión',
                'contrato' => 'torreblanca',
                'coches' => 8,
                'preciocoche' => 22,
                'musicos' => 26,
                'preciomusico' => 65,
                'noaplicapago' => 0,
                'pagado' => 0,
                'observaciones' => 'Salida desde la Colegiata. Traje negro de gala.',
            ],
            [
                'date' => $base->copy()->addDays(20)->setTime(19, 30),
                'descripcion' => 'Gran Concierto de Santa Cecilia 2026',
                'tipo' => 'Concierto Extraordinario',
                'contrato' => 'sanvicente',
                'coches' => 8,
                'preciocoche' => 20,
                'musicos' => 35,
                'preciomusico' => 80,
                'noaplicapago' => 0,
                'pagado' => 0,
                'observaciones' => 'Concierto homenaje con entrega de instrumentos a nuevos músicos.',
            ],
            [
                'date' => $base->copy()->addDays(38)->setTime(11, 0),
                'descripcion' => 'Cercavila i Diana de Festes de Montaverner',
                'tipo' => 'Pasacalle',
                'contrato' => 'montaverner',
                'coches' => 7,
                'preciocoche' => 20,
                'musicos' => 26,
                'preciomusico' => 50,
                'noaplicapago' => 0,
                'pagado' => 0,
                'observaciones' => 'Diana festiva pels carrers de la vila.',
            ],
            [
                'date' => $base->copy()->addDays(42)->setTime(18, 0),
                'descripcion' => 'Gran Entrada de Moros i Cristians de Montaverner',
                'tipo' => 'Entrada Cristiana',
                'contrato' => 'montaverner',
                'coches' => 8,
                'preciocoche' => 22,
                'musicos' => 32,
                'preciomusico' => 85,
                'noaplicapago' => 0,
                'pagado' => 0,
                'observaciones' => 'Desfilada central de les festes patronals.',
            ],
        ];

        return collect($events)->map(function (array $event) use ($contracts, $tipos): Actuacion {
            $totalCoches = $event['coches'] * $event['preciocoche'];
            $totalMusicos = $event['musicos'] * $event['preciomusico'];

            return Actuacion::query()->firstOrCreate(
                ['descripcion' => $event['descripcion']],
                [
                    'fechaActuacion' => $event['date']->format('Y-m-d H:i:s'),
                    'tipoactuacions_id' => $tipos->get($event['tipo'])?->id ?? $tipos->first()?->id,
                    'contratos_id' => $contracts->get($event['contrato'])?->id ?? $contracts->first()?->id,
                    'coches' => $event['coches'],
                    'preciocoche' => $event['preciocoche'],
                    'preciofurgona' => 30.00,
                    'musicos' => $event['musicos'],
                    'preciomusico' => $event['preciomusico'],
                    'totalcoches' => $totalCoches,
                    'totalmusicos' => $totalMusicos,
                    'totalactuacion' => $totalCoches + $totalMusicos,
                    'pagado' => (bool) $event['pagado'],
                    'aplicaporcentaje' => true,
                    'noaplicapago' => (bool) $event['noaplicapago'],
                    'is_draft' => false,
                    'observaciones' => $event['observaciones'],
                ]
            );
        });
    }

    /**
     * Vincula a los músicos famosos en las listas de asistencia de cada actuación.
     *
     * @param  Collection<int, Actuacion>  $actuaciones
     * @param  Collection<int, User>  $musicians
     */
    private function seedListasAndAsistencias(Collection $actuaciones, Collection $musicians): void
    {
        foreach ($actuaciones as $actuacion) {
            $lista = Listas::query()->firstOrCreate(
                ['actuacions_id' => $actuacion->id],
                [
                    'pagada' => $actuacion->pagado,
                    'cuentas' => $actuacion->pagado,
                ]
            );

            // Convocar a todos los músicos famosos
            foreach ($musicians as $mIndex => $musician) {
                $confirmed = ($mIndex % 7 !== 0); // 85% de asistencia realista
                $hasCar = $musician->tienecoche && ($mIndex % 5 === 0);
                $hasVan = $musician->tienefurgo && ($mIndex % 11 === 0);

                ListasUser::query()->firstOrCreate(
                    [
                        'listas_id' => $lista->id,
                        'user_id' => $musician->id,
                    ],
                    [
                        'disponible' => $confirmed ? 1 : 0,
                        'coche' => $hasCar ? 1 : 0,
                        'furgona' => $hasVan ? 1 : 0,
                        'pagada' => $actuacion->pagado ? 1 : 0,
                        'cuentas' => $actuacion->pagado ? 1 : 0,
                        'totalActuacion' => $confirmed ? $actuacion->preciomusico * ($musician->porcentaje / 100) : 0,
                        'totalCoche' => $hasCar ? $actuacion->preciocoche : 0,
                        'totalFurgo' => $hasVan ? $actuacion->preciofurgona : 0,
                        'totalActo' => $confirmed ? ($actuacion->preciomusico * ($musician->porcentaje / 100) + ($hasCar ? $actuacion->preciocoche : 0) + ($hasVan ? $actuacion->preciofurgona : 0)) : 0,
                    ]
                );
            }
        }
    }

    /**
     * Genera remesas de liquidación y pagos asignados a los músicos para alimentar las estadísticas y vistas de pagos.
     *
     * @param  Collection<int, User>  $musicians
     * @param  Collection<int, Actuacion>  $actuaciones
     */
    private function seedPayments(Collection $musicians, Collection $actuaciones): void
    {
        $admin = $musicians->first(fn ($u) => $u->email === 'admin@eband.app') ?? $musicians->first();

        // Buscar actuaciones pasadas pagadas
        $pastPaid = $actuaciones->filter(fn ($a) => $a->pagado && ! $a->noaplicapago);
        if ($pastPaid->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($admin, $musicians, $pastPaid) {
            $remesas = [
                [
                    'descripcion' => 'Liquidació Festes Patronals de Villalba 2026',
                    'fechaPago' => Carbon::now()->subMonths(2)->day(10)->format('Y-m-d'),
                    'actuaciones' => $pastPaid->slice(0, 2),
                ],
                [
                    'descripcion' => 'Liquidació Moros i Cristians d\'Alcolea 2026',
                    'fechaPago' => Carbon::now()->subMonth()->day(15)->format('Y-m-d'),
                    'actuaciones' => $pastPaid->slice(2, 2),
                ],
                [
                    'descripcion' => 'Liquidació Concerts de Temporada d\'Auditori',
                    'fechaPago' => Carbon::now()->subDays(5)->format('Y-m-d'),
                    'actuaciones' => $pastPaid->slice(4),
                ],
            ];

            foreach ($remesas as $rData) {
                $resume = Paymentresume::query()->firstOrCreate(
                    ['descripcion' => $rData['descripcion']],
                    [
                        'user_id' => $admin->id,
                        'created_at' => $rData['fechaPago'],
                        'updated_at' => $rData['fechaPago'],
                    ]
                );

                foreach ($musicians as $musician) {
                    $totalMusician = 0;
                    $listaUserIds = [];

                    foreach ($rData['actuaciones'] as $act) {
                        $lu = ListasUser::query()
                            ->where('listas_id', $act->lista?->id)
                            ->where('user_id', $musician->id)
                            ->where('disponible', 1)
                            ->first();

                        if ($lu) {
                            $totalMusician += $lu->totalActo;
                            $listaUserIds[] = $lu;
                        }
                    }

                    if ($totalMusician > 0 && ! empty($listaUserIds)) {
                        $payment = Payment::query()->create([
                            'users_id' => $musician->id,
                            'paymentresume_id' => $resume->id,
                            'descripcion' => $rData['descripcion'].' - '.$musician->name,
                            'totalPago' => $totalMusician,
                            'fechaPago' => $rData['fechaPago'],
                            'fechaInicio' => Carbon::parse($rData['fechaPago'])->subDays(30)->toDateString(),
                            'fechaFin' => $rData['fechaPago'],
                        ]);

                        foreach ($listaUserIds as $luRecord) {
                            $luRecord->payment_id = $payment->id;
                            $luRecord->pagada = 1;
                            $luRecord->cuentas = 1;
                            $luRecord->save();
                        }
                    }
                }
            }
        });
    }

    /**
     * Programas de concierto y repertorio oficial.
     */
    private function seedConcertPrograms(): void
    {
        $programs = [
            [
                'title' => 'Gran Concert de Santa Cecília 2026',
                'event_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'event_time' => '19:30:00',
                'location' => 'Auditori Municipal de la Societat Musical',
                'participants' => 'Banda Simfònica de la Societat Musical. Director titular: Ludwig van Beethoven. Solista convidat: Wolfgang Amadeus Mozart.',
                'is_published' => true,
                'is_featured' => true,
                'pieces' => [
                    ['title' => 'Lo Cant del Valencià', 'author' => 'Pedro Sosa', 'details' => 'Pasdoble dianer clàssic del repertori valencià.', 'sort_order' => 1],
                    ['title' => 'Concertino per a Clarinet i Banda, Op. 26', 'author' => 'Carl Maria von Weber', 'details' => 'Solista: Wolfgang Amadeus Mozart.', 'sort_order' => 2],
                    ['title' => 'El Olimpo de los Dioses', 'author' => 'Óscar Navarro', 'details' => 'Poema simfònic en 10 moviments.', 'sort_order' => 3],
                    ['title' => 'Pilatus: Mountain of Dragons', 'author' => 'Steven Reineke', 'details' => 'Obra descriptiva simfònica.', 'sort_order' => 4],
                    ['title' => 'Himne de la Comunitat Valenciana', 'author' => 'José Serrano / Maximilià Thous', 'details' => 'Interpretació solemne.', 'sort_order' => 5],
                ],
            ],
            [
                'title' => 'Concert de Primavera i Música Festera',
                'event_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'event_time' => '20:00:00',
                'location' => 'Teatre Principal',
                'participants' => 'Banda Simfònica i Colla de Dolçaines. Director: Ennio Morricone.',
                'is_published' => true,
                'is_featured' => false,
                'pieces' => [
                    ['title' => 'Churumbelerías', 'author' => 'Emilio Cebrián', 'details' => 'Pasdoble taurí clàssic.', 'sort_order' => 1],
                    ['title' => 'El Kábila', 'author' => 'José María Ferrero Pastor', 'details' => 'Marxa mora icònica d\'Ontinyent.', 'sort_order' => 2],
                    ['title' => 'Capità Cristià', 'author' => 'Amando Blanquer Ponsoda', 'details' => 'Marxa cristiana solemne.', 'sort_order' => 3],
                    ['title' => 'Al Cel', 'author' => 'Francisco Valor Llorens', 'details' => 'Marxa mora de gran profunditat expressiva.', 'sort_order' => 4],
                ],
            ],
            [
                'title' => 'Homenatge a la Música de Cinema i Bandes Sonores',
                'event_date' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'event_time' => '21:30:00',
                'location' => 'Auditori Municipal a l\'aire lliure',
                'participants' => 'Banda Simfònica amb projecció audiovisual. Director convidat: Ennio Morricone.',
                'is_published' => true,
                'is_featured' => true,
                'pieces' => [
                    ['title' => 'Cinema Paradiso', 'author' => 'Ennio Morricone', 'details' => 'Tema principal i tema d\'amor.', 'sort_order' => 1],
                    ['title' => 'Star Wars Saga', 'author' => 'John Williams', 'details' => 'Suite simfònica completa.', 'sort_order' => 2],
                    ['title' => 'Gladiator', 'author' => 'Hans Zimmer', 'details' => 'The Battle & Now We Are Free.', 'sort_order' => 3],
                    ['title' => 'La La Land Concert Suite', 'author' => 'Justin Hurwitz', 'details' => 'Medley de temes de jazz i vals.', 'sort_order' => 4],
                ],
            ],
        ];

        foreach ($programs as $pData) {
            $pieces = $pData['pieces'];
            unset($pData['pieces']);

            $program = ConcertProgram::query()->updateOrCreate(
                ['title' => $pData['title']],
                $pData
            );

            $program->pieces()->delete();
            foreach ($pieces as $piece) {
                $program->pieces()->create($piece);
            }
        }
    }

    /**
     * Comentarios realistas publicados por los músicos famosos en las actuaciones.
     *
     * @param  Collection<int, Actuacion>  $actuaciones
     * @param  Collection<int, User>  $musicians
     */
    private function seedComments(Collection $actuaciones, Collection $musicians): void
    {
        $comentarios = [
            '¡Excelente balance de sonido en el tutti final! Por favor, cuidemos los pianos en compás 45.',
            'Recordad llevar atril portátil y pinzas dobles para el viento en el desfile.',
            'Coche disponible para 4 músicos desde el local de ensayo. Salida a las 17:00 en punto.',
            'Los clarinetes tenemos afinación perfecta hoy, ¡gran trabajo de sección!',
            'Revisemos bien los cambios de compás en el ensayo general de mañana.',
            'La acústica del auditorio es maravillosa, disfrutaremos mucho el concierto de Santa Cecilia.',
            'Furgoneta lista con toda la percusión pesada, bombos y atriles cargados.',
            'Traed camisa blanca de manga larga y corbata verde oficial de la sociedad.',
            'Gracias a la junta por el refrigerio al acabar el desfile, ¡estuvo genial!',
            'Por motivos de trabajo llegaré 15 minutos tarde, guardadme sitio en la cuerda de trombones.',
        ];

        foreach ($actuaciones as $index => $actuacion) {
            if (! Comment::query()->where('actuacion_id', $actuacion->id)->exists() && $musicians->isNotEmpty()) {
                $author = $musicians->get($index % $musicians->count());
                Comment::query()->create([
                    'comment' => $comentarios[$index % count($comentarios)],
                    'inadecuado' => false,
                    'eliminado' => false,
                    'user_id' => $author->id,
                    'actuacion_id' => $actuacion->id,
                    'data' => json_encode(['from_device' => 'app']),
                    'created_at' => Carbon::now()->subDays(max(1, 10 - $index)),
                    'updated_at' => Carbon::now()->subDays(max(1, 10 - $index)),
                ]);
            }
        }
    }

    /**
     * Anuncios en el tablón de la banda.
     *
     * @param  Collection<int, User>  $musicians
     */
    private function seedAnnouncements(Collection $musicians): void
    {
        $creator = $musicians->first(fn ($u) => $u->email === 'admin@eband.app') ?? $musicians->first();

        $announcements = [
            [
                'title' => 'Calendario Oficial de Ensayos y Fiestas 2026',
                'body' => 'Ya podéis consultar en la aplicación todo el calendario actualizado de ensayos, conciertos y salidas de Moros y Cristianos para esta temporada.',
            ],
            [
                'title' => 'Recogida de Nuevos Uniformes y Polos Corporativos',
                'body' => 'Los nuevos polos y chaquetas de la sociedad musical están disponibles en secretaría para los músicos convocados a las próximas actuaciones.',
            ],
            [
                'title' => 'Confirmación de Asistencia y Coordinación de Vehículos',
                'body' => 'Por favor, confirmad vuestra disponibilidad con suficiente antelación a través de la app para que la dirección pueda organizar los atriles y el transporte.',
            ],
        ];

        foreach ($announcements as $item) {
            Announcement::query()->firstOrCreate(
                ['title' => $item['title']],
                [
                    'body' => $item['body'],
                    'content_view' => null,
                    'redirect_url' => null,
                    'starts_at' => now()->subDays(5),
                    'ends_at' => now()->addDays(90),
                    'is_active' => true,
                    'applies_to_all' => true,
                    'created_by' => $creator->id,
                    'notified_at' => now()->subDays(5),
                ]
            );
        }
    }

    /**
     * Materiales e inventario asignados a los músicos.
     *
     * @param  Collection<int, User>  $musicians
     */
    private function seedInventory(Collection $musicians): void
    {
        $viento = InventoryCategory::query()->firstOrCreate(['nombre' => 'Instrumentos de viento']);
        $percusion = InventoryCategory::query()->firstOrCreate(['nombre' => 'Percusión y escenario']);
        $uniformes = InventoryCategory::query()->firstOrCreate(['nombre' => 'Uniformes y complementos']);

        $items = [
            ['category' => $viento->id, 'nombre' => 'Tuba Sib Yamaha YBB-321', 'cantidad' => 2, 'valor' => 3850.00, 'estado' => 'usado', 'musico' => 'Gustav Mahler'],
            ['category' => $viento->id, 'nombre' => 'Saxofón Barítono Selmer Series II', 'cantidad' => 1, 'valor' => 4600.00, 'estado' => 'usado', 'musico' => 'Sonny Rollins'],
            ['category' => $viento->id, 'nombre' => 'Trombón de varas Vincent Bach Stradivarius', 'cantidad' => 3, 'valor' => 1850.00, 'estado' => 'usado', 'musico' => 'Giuseppe Verdi'],
            ['category' => $viento->id, 'nombre' => 'Bombardino Besson Sovereign', 'cantidad' => 1, 'valor' => 3200.00, 'estado' => 'usado', 'musico' => 'Johannes Brahms'],
            ['category' => $percusion->id, 'nombre' => 'Bombo Sinfónico Adams 36" con soporte basculante', 'cantidad' => 1, 'valor' => 1750.00, 'estado' => 'usado', 'musico' => 'Buddy Rich'],
            ['category' => $percusion->id, 'nombre' => 'Juego de Timbales Sinfónicos Ludwig Grand Concert (4 timbales)', 'cantidad' => 4, 'valor' => 5400.00, 'estado' => 'usado', 'musico' => 'Maurice Ravel'],
            ['category' => $percusion->id, 'nombre' => 'Juego de platos de choque Zildjian K Constantinople 18"', 'cantidad' => 2, 'valor' => 680.00, 'estado' => 'nuevo', 'musico' => 'Tito Puente'],
            ['category' => $percusion->id, 'nombre' => 'Atriles metálicos reforzados para concierto', 'cantidad' => 40, 'valor' => 42.00, 'estado' => 'nuevo', 'musico' => 'Ludwig van Beethoven'],
            ['category' => $uniformes->id, 'nombre' => 'Corbata verde corporativa oficial eBand', 'cantidad' => 50, 'valor' => 15.00, 'estado' => 'nuevo', 'musico' => 'Wolfgang Amadeus Mozart'],
        ];

        foreach ($items as $item) {
            $record = InventoryItem::query()->firstOrCreate(
                ['nombre' => $item['nombre']],
                [
                    'inventory_category_id' => $item['category'],
                    'year' => now()->year,
                    'cantidad' => $item['cantidad'],
                    'valor_unitario' => $item['valor'],
                    'estado' => $item['estado'],
                    'observaciones' => 'Material catalogado de la sociedad musical.',
                    'depreciation_rate' => 5.00,
                    'purchase_date' => now()->subMonths(8)->toDateString(),
                ]
            );

            // Asignar al músico famoso responsable
            $assignedMusician = $musicians->first(fn ($m) => $m->name === $item['musico']) ?? $musicians->first();
            if ($assignedMusician && ! $record->responsables()->where('users.id', $assignedMusician->id)->exists()) {
                $record->responsables()->attach($assignedMusician->id);
            }
        }
    }
}
