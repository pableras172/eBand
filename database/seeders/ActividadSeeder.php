<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Actividad;
use App\Models\ActividadInscripcion;
use App\Models\ActividadInscripcionItem;
use App\Models\ActividadOpcion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()->where('activo', true)->get();
        if ($users->isEmpty()) {
            $users = User::query()->get();
        }

        $actividadesData = [
            [
                'titulo' => 'Dinar de Germanor de Santa Cecília',
                'tipo' => 'comida',
                'es_de_pago' => true,
                'descripcion' => "Tradicional dinar de germanor de la Societat Musical per a celebrar la patrona de la música.\nConvidem a tots els músics, educands de l'escola i acompanyants a compartir esta jornada festiva.",
                'lugar' => 'Salons Alameda Palace (València)',
                'fecha' => Carbon::now()->addDays(6)->setTime(14, 30),
                'fecha_limite_inscripcion' => Carbon::now()->addDays(4)->setTime(23, 59),
                'estado' => 'abierta',
                'instrucciones_pago' => 'Podeu realitzar el pagament per Bizum al 600123456 indicant el vostre nom i "Santa Cecília" o en efectiu a secretaria.',
                'opciones' => [
                    [
                        'titulo' => 'Menú Adult Músic / Acompanyant',
                        'descripcion' => 'Entrants al centre, plat principal a triar (carn/peix), postre, cafè i beguda.',
                        'precio' => 25.00,
                        'orden' => 1,
                    ],
                    [
                        'titulo' => 'Menú Infantil / Educands',
                        'descripcion' => 'Plat combinat infantil, beguda i gelat.',
                        'precio' => 12.00,
                        'orden' => 2,
                    ],
                    [
                        'titulo' => 'Menú Vegetarià / Celíac',
                        'descripcion' => 'Menú complet adaptat a intoleràncies o preferències vegetarianes.',
                        'precio' => 25.00,
                        'orden' => 3,
                    ],
                ],
            ],
            [
                'titulo' => 'Concert de Gala i Presentació del Disc',
                'tipo' => 'concierto',
                'es_de_pago' => false,
                'descripcion' => "Presentació oficial del nou treball discogràfic gravat per la banda simfònica.\nEntrada lliure per a músics, socis i familiars fins a completar aforament de la sala principal.",
                'lugar' => 'Auditori Municipal',
                'fecha' => Carbon::now()->addDays(14)->setTime(19, 30),
                'fecha_limite_inscripcion' => Carbon::now()->addDays(12)->setTime(20, 00),
                'estado' => 'abierta',
                'instrucciones_pago' => null,
                'opciones' => [
                    [
                        'titulo' => 'Entrada General Gratuïta',
                        'descripcion' => 'Reserva de butaca per al concert de gala.',
                        'precio' => 0.00,
                        'orden' => 1,
                    ],
                ],
            ],
            [
                'titulo' => 'Excursió i Intercanvi Musical a Bunyol',
                'tipo' => 'excursion',
                'es_de_pago' => true,
                'descripcion' => "Viatge en autobús i jornada de convivència amb la societat musical de Bunyol.\nInclou trasllat en autobús, visita guiada pel municipi i dinar típic de germanor.",
                'lugar' => 'Bunyol (Hoya de Buñol)',
                'fecha' => Carbon::now()->addDays(22)->setTime(9, 00),
                'fecha_limite_inscripcion' => Carbon::now()->addDays(18)->setTime(23, 59),
                'estado' => 'abierta',
                'instrucciones_pago' => 'Transferència al compte de la banda ES12 3456 7890 1234 o per Bizum.',
                'opciones' => [
                    [
                        'titulo' => 'Plaça Bus + Dinar de Germanor',
                        'descripcion' => 'Viatge complet amb autobús d\'anada i tornada i dinar.',
                        'precio' => 20.00,
                        'orden' => 1,
                    ],
                    [
                        'titulo' => 'Només Dinar (desplaçament propi)',
                        'descripcion' => 'Per a qui es desplace amb vehicle propi.',
                        'precio' => 15.00,
                        'orden' => 2,
                    ],
                ],
            ],
            [
                'titulo' => "Sopar d'Estiu i Festa Fi de Curs",
                'tipo' => 'cena',
                'es_de_pago' => true,
                'descripcion' => 'Festa de tancament de temporada a la terrassa del local de la banda amb música en directe, paella nocturna i entrega de reconeixements.',
                'lugar' => 'Terrassa de la Societat Musical',
                'fecha' => Carbon::now()->addDays(35)->setTime(21, 30),
                'fecha_limite_inscripcion' => Carbon::now()->addDays(30)->setTime(23, 59),
                'estado' => 'abierta',
                'instrucciones_pago' => 'En efectiu a secretaria abans de la data límit.',
                'opciones' => [
                    [
                        'titulo' => 'Tiquet Sopar + Barra Lliure Refrescos',
                        'descripcion' => 'Sopar complet amb beguda inclosa.',
                        'precio' => 15.00,
                        'orden' => 1,
                    ],
                ],
            ],
        ];

        foreach ($actividadesData as $actData) {
            $opciones = $actData['opciones'] ?? [];
            unset($actData['opciones']);

            /** @var Actividad $actividad */
            $actividad = Actividad::query()->updateOrCreate(
                ['titulo' => $actData['titulo']],
                $actData
            );

            $opcionesCreadas = [];
            foreach ($opciones as $opcData) {
                $opc = ActividadOpcion::query()->updateOrCreate(
                    [
                        'actividad_id' => $actividad->id,
                        'titulo' => $opcData['titulo'],
                    ],
                    [
                        'descripcion' => $opcData['descripcion'] ?? null,
                        'precio' => $opcData['precio'] ?? 0.00,
                        'orden' => $opcData['orden'] ?? 0,
                    ]
                );
                $opcionesCreadas[] = $opc;
            }

            // Inscribir a algunos usuarios de muestra para dar vida y métricas a la actividad
            if ($users->isNotEmpty() && ! empty($opcionesCreadas)) {
                $sampleUsers = $users->take(min(5, $users->count()));
                foreach ($sampleUsers as $idx => $sampleUser) {
                    $opcionSeleccionada = $opcionesCreadas[$idx % count($opcionesCreadas)];
                    $precio = (float) $opcionSeleccionada->precio;

                    /** @var ActividadInscripcion $inscripcion */
                    $inscripcion = ActividadInscripcion::query()->updateOrCreate(
                        [
                            'actividad_id' => $actividad->id,
                            'user_id' => $sampleUser->id,
                        ],
                        [
                            'asiste' => true,
                            'fecha_inscripcion' => Carbon::now()->subDays(2),
                            'total' => $precio,
                            'observaciones_alergias' => ($idx === 1) ? 'Sense gluten (celíac)' : null,
                            'pagado' => ($idx % 2 === 0),
                            'metodo_pago' => ($idx % 2 === 0) ? 'bizum' : null,
                            'fecha_pago' => ($idx % 2 === 0) ? Carbon::now()->subDay() : null,
                        ]
                    );

                    ActividadInscripcionItem::query()->updateOrCreate(
                        [
                            'actividad_inscripcion_id' => $inscripcion->id,
                            'actividad_opcion_id' => $opcionSeleccionada->id,
                        ],
                        [
                            'cantidad' => 1,
                            'precio_unitario' => $precio,
                            'subtotal' => $precio,
                        ]
                    );
                }
            }
        }
    }
}
