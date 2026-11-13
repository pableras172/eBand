<?php

namespace Database\Seeders;

use App\Models\Actuacion;
use App\Models\Comment;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Pobla comentaris realistes relacionats amb actuacions, assajos i vida de la societat musical.
     */
    public function run(): void
    {
        // Assegurar inicialització del tenant si s'executa aïlladament
        if (! tenancy()->initialized) {
            $tenant = Tenant::find('demo') ?? Tenant::first();
            if ($tenant) {
                tenancy()->initialize($tenant);
            }
        }

        $users = User::all();
        $actuaciones = Actuacion::all();

        if ($users->isEmpty() || $actuaciones->isEmpty()) {
            $this->command?->warn('No es poden generar comentaris perquè no hi ha usuaris o actuacions.');

            return;
        }

        $comentariosEjemplo = [
            [
                'comment' => 'Recordeu portar la camisa blanca de mànega llarga, pantaló negre i la corbata verda corporativa de la societat.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 8,
                'device' => 'android',
                'days_ago' => 1,
            ],
            [
                'comment' => 'Arribaré uns 15 minuts tard a l\'assaig general per motius de feina. Per favor, guardeu-me lloc i faristol a la corda de saxos!',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 4,
                'device' => 'ios',
                'days_ago' => 2,
            ],
            [
                'comment' => 'Algú té un faristol de carrer (de pinça per a clarinet) de sobra que em puga deixar per a la cercavila d\'este dissabte?',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 2,
                'device' => 'web',
                'days_ago' => 3,
            ],
            [
                'comment' => 'A quina hora exacta eixirà l\'autobús des de la seu social per a desplaçar-nos a l\'entrada de festes?',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 6,
                'device' => 'android',
                'days_ago' => 4,
            ],
            [
                'comment' => 'Ja estan impreses i repartides les noves particel·les del pasdoble i la marxa mora a l\'arxiu. Qui falte que passe abans de començar.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 11,
                'device' => 'web',
                'days_ago' => 5,
            ],
            [
                'comment' => 'Enhorabona a tota la banda pel concert d\'ahir! L\'acústica de l\'auditori i el solo de clarinet van ser espectaculars.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 19,
                'device' => 'ios',
                'days_ago' => 6,
            ],
            [
                'comment' => 'Atenció: l\'aparcament del carrer Sant Vicent estarà tallat per obres. És millor aparcar al pàrquing públic del poliesportiu.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 7,
                'device' => 'android',
                'days_ago' => 7,
            ],
            [
                'comment' => 'Confirmem qui carregarà la furgoneta amb les tubes, bombardins i la percussió pesada a les 16:30.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 5,
                'device' => 'web',
                'days_ago' => 8,
            ],
            [
                'comment' => 'Si fa fresca a la nit portem la jaqueta de l\'uniforme d\'hivern o només el jupetí? Confirmeu per favor.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 3,
                'device' => 'ios',
                'days_ago' => 10,
            ],
            [
                'comment' => 'Molt bon ambient i acollida magnífica per part de la comissió de festes. Gràcies a tots pel compromís!',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 14,
                'device' => 'android',
                'days_ago' => 12,
            ],
            [
                'comment' => 'Els horaris d\'eixida són una vergonya, sempre tard i sense organització...',
                'inadecuado' => true,
                'eliminado' => false,
                'likes' => 0,
                'device' => 'web',
                'days_ago' => 14,
            ],
            [
                'comment' => 'Comentari de prova eliminat per l\'administració de la banda.',
                'inadecuado' => false,
                'eliminado' => true,
                'likes' => 0,
                'device' => 'web',
                'days_ago' => 15,
            ],
            [
                'comment' => 'Missatge inadequat reportat per diversos membres de la corda de percussió.',
                'inadecuado' => true,
                'eliminado' => true,
                'likes' => 0,
                'device' => 'ios',
                'days_ago' => 18,
            ],
            [
                'comment' => 'Recordatori: en acabar la processó hi haurà sopar de germanor per a tots els músics a la seu de la societat musical.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 15,
                'device' => 'android',
                'days_ago' => 20,
            ],
            [
                'comment' => 'Tinc dues places lliures al meu cotxe per als qui vinguen des del poble veí, contacteu-me per privat.',
                'inadecuado' => false,
                'eliminado' => false,
                'likes' => 4,
                'device' => 'ios',
                'days_ago' => 22,
            ],
        ];

        // Esborrar comentaris previs per a deixar un estat net i consistent
        Comment::truncate();

        foreach ($comentariosEjemplo as $index => $item) {
            $user = $users[$index % $users->count()];
            $actuacion = $actuaciones[$index % $actuaciones->count()];

            Comment::create([
                'comment' => $item['comment'],
                'inadecuado' => $item['inadecuado'],
                'eliminado' => $item['eliminado'],
                'user_id' => $user->id,
                'actuacion_id' => $actuacion->id,
                'data' => json_encode([
                    'likes' => $item['likes'],
                    'from_device' => $item['device'],
                ]),
                'created_at' => Carbon::now()->subDays($item['days_ago'])->subHours(rand(1, 10)),
                'updated_at' => Carbon::now()->subDays($item['days_ago']),
            ]);
        }

        $this->command?->info('Comentaris realistes creats amb èxit ('.count($comentariosEjemplo).' comentaris).');
    }
}
