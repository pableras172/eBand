<?php

namespace Database\Seeders;

use App\Models\ConcertProgram;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ConcertProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegurar que el tenant demo esté inicializado si se ejecuta individualmente
        if (! tenancy()->initialized) {
            $tenant = Tenant::find('demo') ?? Tenant::first();
            if ($tenant) {
                tenancy()->initialize($tenant);
            }
        }

        $programsData = [
            [
                'title' => 'Gran Concert de Santa Cecília 2026',
                'event_date' => Carbon::now()->addDays(14)->format('Y-m-d'),
                'event_time' => '19:30:00',
                'location' => 'Auditori Municipal de la Societat Musical',
                'participants' => 'Banda Simfònica de la Societat Musical. Director titular: Mestre Vicent Ferrando. Solista de clarinet convidada: Laura Marí.',
                'is_published' => true,
                'is_featured' => true,
                'pieces' => [
                    [
                        'title' => 'Lo Cant del Valencià',
                        'author' => 'Pedro Sosa',
                        'details' => 'Pasdoble dianer clàssic del repertori valencià.',
                        'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Concertino per a Clarinet i Banda, Op. 26',
                        'author' => 'Carl Maria von Weber (arr. G. Pares)',
                        'details' => 'I. Adagio ma non troppo - II. Andante - III. Tema con variazioni. Solista de clarinet: Laura Marí.',
                        'url' => null,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'El Olimpo de los Dioses',
                        'author' => 'Óscar Navarro',
                        'details' => 'Poema simfònic en 10 moviments inspirat en la mitologia grega (Hermes, Artemisa, Poseidón, Zeus...).',
                        'url' => 'https://www.youtube.com',
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'Pilatus: Mountain of Dragons',
                        'author' => 'Steven Reineke',
                        'details' => 'Obra simfònica descriptiva que narra la llegenda dels dracs del massís de Pilatus.',
                        'url' => null,
                        'sort_order' => 4,
                    ],
                    [
                        'title' => 'Himne de la Comunitat Valenciana',
                        'author' => 'José Serrano / Maximilià Thous',
                        'details' => 'Interpretació solemne d\'homenatge als nous músics de la societat.',
                        'url' => null,
                        'sort_order' => 5,
                    ],
                ],
            ],
            [
                'title' => 'Concert de Primavera i Música Festera',
                'event_date' => Carbon::now()->addMonths(2)->format('Y-m-d'),
                'event_time' => '20:00:00',
                'location' => 'Teatre Principal',
                'participants' => 'Banda Simfònica i Colla de Dolçaines i Tabals. Director convidat: Ferran Gómez.',
                'is_published' => true,
                'is_featured' => false,
                'pieces' => [
                    [
                        'title' => 'Churumbelerías',
                        'author' => 'Emilio Cebrián',
                        'details' => 'Pasdoble espanyol festiu.',
                        'url' => null,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'El President',
                        'author' => 'Miguel Ángel Mas Mataix',
                        'details' => 'Marxa cristiana triomfal.',
                        'url' => null,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Chimo',
                        'author' => 'José María Ferrero Pastor',
                        'details' => 'Marxa mora monumental i emblemàtica de les festes de Moros i Cristians.',
                        'url' => 'https://www.youtube.com',
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'Tarde de Abril',
                        'author' => 'Amando Blanquer Ponsoda',
                        'details' => 'Marxa mora simfònica.',
                        'url' => null,
                        'sort_order' => 4,
                    ],
                    [
                        'title' => 'Als Ligeros',
                        'author' => 'José María Ferrero Pastor',
                        'details' => 'Marxa cristiana amb acompanyament de percussió medieval.',
                        'url' => null,
                        'sort_order' => 5,
                    ],
                ],
            ],
            [
                'title' => 'Festival de Bandes Juvenils: Bandes Sonores de Cinema',
                'event_date' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'event_time' => '18:30:00',
                'location' => 'Plaça Major (A l\'aire lliure)',
                'participants' => 'Banda Jove de la Societat Musical i Banda Jove Convidada d\'Ontinyent. Directora: Mireia Sanç.',
                'is_published' => true,
                'is_featured' => false,
                'pieces' => [
                    [
                        'title' => 'Highlights from Jurassic Park',
                        'author' => 'John Williams (arr. Michael Sweeney)',
                        'details' => 'Selecció dels temes principals de la saga juràssica.',
                        'url' => null,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'How to Train Your Dragon',
                        'author' => 'John Powell (arr. Sean O\'Loughlin)',
                        'details' => 'Suite de la banda sonora de la pel·lícula d\'animació.',
                        'url' => null,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Coldplay on Stage',
                        'author' => 'Coldplay (arr. Michael Brown)',
                        'details' => 'Medley amb Viva la Vida, Clocks i Fix You.',
                        'url' => null,
                        'sort_order' => 3,
                    ],
                    [
                        'title' => 'Santana in Concert',
                        'author' => 'Carlos Santana (arr. Giancarlo Gazzani)',
                        'details' => 'Oye cómo va, Flor de luna i Europa.',
                        'url' => null,
                        'sort_order' => 4,
                    ],
                ],
            ],
            [
                'title' => 'Concert Extraordinari de Cap d\'Any i Reis 2027',
                'event_date' => Carbon::now()->startOfYear()->addYear()->addDays(2)->format('Y-m-d'),
                'event_time' => '19:00:00',
                'location' => 'Gran Teatre Auditori',
                'participants' => 'Banda Simfònica i Veus Solistes.',
                'is_published' => false,
                'is_featured' => false,
                'pieces' => [
                    [
                        'title' => 'Al Bell Danubi Blau (An der schönen blauen Donau), Op. 314',
                        'author' => 'Johann Strauss II',
                        'details' => 'El vals vienés per excel·lència.',
                        'url' => null,
                        'sort_order' => 1,
                    ],
                    [
                        'title' => 'Tritsch-Tratsch-Polka, Op. 214',
                        'author' => 'Johann Strauss II',
                        'details' => 'Polka rápida i festiva de celebració d\'Any Nou.',
                        'url' => null,
                        'sort_order' => 2,
                    ],
                    [
                        'title' => 'Marxa Radetzky, Op. 228',
                        'author' => 'Johann Strauss I',
                        'details' => 'Tradicional tancament amb participació del públic mitjançant palmes.',
                        'url' => null,
                        'sort_order' => 3,
                    ],
                ],
            ],
        ];

        foreach ($programsData as $pData) {
            $pieces = $pData['pieces'];
            unset($pData['pieces']);

            // Crear o actualizar el programa
            $program = ConcertProgram::updateOrCreate(
                ['title' => $pData['title']],
                $pData
            );

            // Sincronizar piezas del repertorio
            $program->pieces()->delete();
            foreach ($pieces as $piece) {
                $program->pieces()->create($piece);
            }
        }

        $this->command?->info('Programes de concert i repertori creats amb èxit ('.count($programsData).' programes).');
    }
}
