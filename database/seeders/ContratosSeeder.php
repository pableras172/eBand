<?php

namespace Database\Seeders;

use App\Models\Actuacion;
use App\Models\Contratos;
use App\Models\Listas;
use App\Models\ListasUser;
use App\Models\Tenant;
use App\Models\Tipoactuacion;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContratosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Si no está inicializado un tenant, inicializar 'demo' por defecto
        if (! tenancy()->initialized) {
            $tenant = Tenant::find('demo') ?? Tenant::first();
            if ($tenant) {
                tenancy()->initialize($tenant);
            }
        }

        // Eliminar posibles contratos de prueba antiguos
        Contratos::whereIn('poblacion', ['Ciudad A', 'Ciudad B'])->delete();

        $users = User::all();
        $tipos = Tipoactuacion::all()->keyBy('nombre');

        // Mapeo seguro de tipos
        $getIdTipo = function (string $nombrePreferente) use ($tipos) {
            if ($tipos->has($nombrePreferente)) {
                return $tipos->get($nombrePreferente)->id;
            }
            $fallback = $tipos->first();

            return $fallback ? $fallback->id : 1;
        };

        $contratosData = [
            [
                'poblacion' => 'Llíria - Ciutat de la Música',
                'latitude' => 39.6253400,
                'longitude' => -0.5960200,
                'fechainicio' => '2026-05-15',
                'fechafin' => '2026-05-24',
                'anyo' => 2026,
                'descripcion' => 'Festival Internacional de Bandes - Llíria Ciutat Creativa UNESCO',
                'contacto' => 'Vicent Gómez Ferrer (Comissió Musical)',
                'telefono' => '654 321 001',
                'correo' => 'musica@lliria.es',
                'dnicontacto' => '20845123A',
                'observacions' => 'Concerts al Teatre de la Unió Musical i cercaviles pel barri antic. Uniforme complet de gala.',
                'actuaciones' => [
                    [
                        'fechaActuacion' => '2026-05-16',
                        'descripcion' => 'Concert de Gala de Primavera - Teatre de la Unió',
                        'tipo' => 'Ensayo',
                        'musicos' => 65,
                        'preciomusico' => 55.00,
                        'coches' => 12,
                        'preciocoche' => 20.00,
                        'furgonas' => 1,
                        'preciofurgona' => 35.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Obres obligades i pasdoble d\'obertura. Proves acústiques a les 17:30h.',
                    ],
                    [
                        'fechaActuacion' => '2026-05-22',
                        'descripcion' => 'Cercavila Commemorativa Ciutat de la Música',
                        'tipo' => 'Pasacalle',
                        'musicos' => 55,
                        'preciomusico' => 45.00,
                        'coches' => 10,
                        'preciocoche' => 18.00,
                        'furgonas' => 1,
                        'preciofurgona' => 35.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Recorregut des de la Plaça Major fins al Conservatori.',
                    ],
                    [
                        'fechaActuacion' => '2026-05-24',
                        'descripcion' => 'Concert de Cloenda i Homenatge al Mestre Director',
                        'tipo' => 'Parcial',
                        'musicos' => 70,
                        'preciomusico' => 60.00,
                        'coches' => 14,
                        'preciocoche' => 20.00,
                        'furgonas' => 2,
                        'preciofurgona' => 40.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Gravació en directe per a l\'arxiu històric municipal.',
                    ],
                ],
            ],
            [
                'poblacion' => 'Cullera - Auditori Municipal',
                'latitude' => 39.1638900,
                'longitude' => -0.2527800,
                'fechainicio' => '2026-04-10',
                'fechafin' => '2026-04-19',
                'anyo' => 2026,
                'descripcion' => 'LXXVIII Certamen Nacional de Bandes de Música "Ciutat de Cullera"',
                'contacto' => 'Amparo Ribes Sanç (Directora Artística)',
                'telefono' => '670 112 233',
                'correo' => 'certamencullera@cullera.org',
                'dnicontacto' => '21456987B',
                'observacions' => 'Concurs oficial a l\'Auditori Municipal del Mercat. Màxima puntualitat requerida.',
                'actuaciones' => [
                    [
                        'fechaActuacion' => '2026-04-11',
                        'descripcion' => 'Desfilada Prèvia de Bandes Participants',
                        'tipo' => 'Pasacalle',
                        'musicos' => 60,
                        'preciomusico' => 40.00,
                        'coches' => 11,
                        'preciocoche' => 22.00,
                        'furgonas' => 1,
                        'preciofurgona' => 30.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Desfilada pels carrers cèntrics de Cullera fins a l\'auditori.',
                    ],
                    [
                        'fechaActuacion' => '2026-04-12',
                        'descripcion' => 'Actuació del Certamen: Obra Obligada i Obra Lliure',
                        'tipo' => 'Ensayo',
                        'musicos' => 80,
                        'preciomusico' => 75.00,
                        'coches' => 16,
                        'preciocoche' => 25.00,
                        'furgonas' => 2,
                        'preciofurgona' => 45.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Interpretació davant el Jurat Internacional del Certamen.',
                    ],
                ],
            ],
            [
                'poblacion' => 'València - Palau de la Música',
                'latitude' => 39.4678100,
                'longitude' => -0.3547200,
                'fechainicio' => '2026-11-18',
                'fechafin' => '2026-11-23',
                'anyo' => 2026,
                'descripcion' => 'Cicle de Concerts de Santa Cecília - Palau de la Música de València',
                'contacto' => 'Francesc Xavier Blasco (Programació Cultural)',
                'telefono' => '619 887 766',
                'correo' => 'palaumusica@valencia.es',
                'dnicontacto' => '22987456C',
                'observacions' => 'Sala Iturbi. Escenari habilitat per a 90 intèrprets i percussió completa.',
                'actuaciones' => [
                    [
                        'fechaActuacion' => '2026-11-20',
                        'descripcion' => 'Assaig General Acústic a la Sala Iturbi',
                        'tipo' => 'Ensayo',
                        'musicos' => 75,
                        'preciomusico' => 35.00,
                        'coches' => 12,
                        'preciocoche' => 15.00,
                        'furgonas' => 2,
                        'preciofurgona' => 30.00,
                        'oficial' => false,
                        'is_draft' => false,
                        'observaciones' => 'Assaig d\'ajust amb instruments de metall i percussió pesada.',
                    ],
                    [
                        'fechaActuacion' => '2026-11-22',
                        'descripcion' => 'Gran Concert Extraordinari de Santa Cecília',
                        'tipo' => 'Ensayo',
                        'musicos' => 85,
                        'preciomusico' => 70.00,
                        'coches' => 15,
                        'preciocoche' => 20.00,
                        'furgonas' => 2,
                        'preciofurgona' => 40.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Entrada lliure fins a completar aforament. Emissió en streaming.',
                    ],
                ],
            ],
            [
                'poblacion' => 'Buñol - Auditorio Municipal de San Luis',
                'latitude' => 39.4184300,
                'longitude' => -0.7915500,
                'fechainicio' => '2026-08-18',
                'fechafin' => '2026-08-25',
                'anyo' => 2026,
                'descripcion' => 'Concert Tradicional "Mà a Mà de Buñol" a l\'Auditori de San Luis',
                'contacto' => 'Manel Carrascosa (Societat Musical)',
                'telefono' => '633 445 566',
                'correo' => 'manoamano@bunol.es',
                'dnicontacto' => '19874563D',
                'observacions' => 'El concert a l\'aire lliure més prestigiós del panorama bandístic valencià.',
                'actuaciones' => [
                    [
                        'fechaActuacion' => '2026-08-22',
                        'descripcion' => 'Gran Concert Simfònic del Mà a Mà',
                        'tipo' => 'Ensayo',
                        'musicos' => 90,
                        'preciomusico' => 80.00,
                        'coches' => 18,
                        'preciocoche' => 25.00,
                        'furgonas' => 2,
                        'preciofurgona' => 50.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Auditori de San Luis. Acústica natural a la roca.',
                    ],
                ],
            ],
            [
                'poblacion' => 'Altea - Palau Altea Centre d\'Arts',
                'latitude' => 38.6046000,
                'longitude' => -0.0483200,
                'fechainicio' => '2026-11-28',
                'fechafin' => '2026-12-06',
                'anyo' => 2026,
                'descripcion' => 'Certamen Internacional de Música de Banda Villa d\'Altea (CIM Altea)',
                'contacto' => 'Elena Barber Mas (Coordinació Artística)',
                'telefono' => '689 332 211',
                'correo' => 'cimaltea@altea.es',
                'dnicontacto' => '21654987E',
                'observacions' => 'Participació en la secció simfònica d\'honor.',
                'actuaciones' => [
                    [
                        'fechaActuacion' => '2026-12-05',
                        'descripcion' => 'Concert de Competició al Palau Altea',
                        'tipo' => 'Ensayo',
                        'musicos' => 75,
                        'preciomusico' => 65.00,
                        'coches' => 14,
                        'preciocoche' => 22.00,
                        'furgonas' => 2,
                        'preciofurgona' => 45.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Interpretació de la simfonia obligada del CIM Altea.',
                    ],
                ],
            ],
            [
                'poblacion' => 'Alcoi - Plaça d\'Espanya',
                'latitude' => 38.6983000,
                'longitude' => -0.4739200,
                'fechainicio' => '2026-04-21',
                'fechafin' => '2026-04-26',
                'anyo' => 2026,
                'descripcion' => 'Festes de Moros i Cristians d\'Alcoi - Acompanyament Fester Oficial',
                'contacto' => 'Jordi Silvestre Miralles (Associació de Sant Jordi)',
                'telefono' => '622 778 899',
                'correo' => 'musica@santjordi.org',
                'dnicontacto' => '21987654F',
                'observacions' => 'Interpretació de Marxes Mores i Cristianes per l\'esquadra d\'enmig i el capità.',
                'actuaciones' => [
                    [
                        'fechaActuacion' => '2026-04-22',
                        'descripcion' => 'Dia dels Músics i Himne de la Festa a la Plaça d\'Espanya',
                        'tipo' => 'Pasacalle',
                        'musicos' => 60,
                        'preciomusico' => 50.00,
                        'coches' => 12,
                        'preciocoche' => 18.00,
                        'furgonas' => 1,
                        'preciofurgona' => 30.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Interpretació conjunta de l\'Himne de la Festa per més de mil músics.',
                    ],
                    [
                        'fechaActuacion' => '2026-04-23',
                        'descripcion' => 'Entrada de Cristians - Acompanyament Filà Alcodians',
                        'tipo' => 'Entrada Cristiana',
                        'musicos' => 55,
                        'preciomusico' => 60.00,
                        'coches' => 10,
                        'preciocoche' => 20.00,
                        'furgonas' => 1,
                        'preciofurgona' => 35.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Marxes cristianes i fanfàrries heroiques.',
                    ],
                    [
                        'fechaActuacion' => '2026-04-24',
                        'descripcion' => 'Entrada de Moros - Marxa Mora i Acompanyament de Boato',
                        'tipo' => 'Entrada Mora',
                        'musicos' => 58,
                        'preciomusico' => 65.00,
                        'coches' => 11,
                        'preciocoche' => 20.00,
                        'furgonas' => 1,
                        'preciofurgona' => 35.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Acompanyament musical a l\'esquadra d\'especials.',
                    ],
                ],
            ],
            [
                'poblacion' => 'Castelló de la Plana - Auditori i Palau de Congressos',
                'latitude' => 39.9918000,
                'longitude' => -0.0494000,
                'fechainicio' => '2026-10-09',
                'fechafin' => '2026-10-12',
                'anyo' => 2026,
                'descripcion' => 'Concert Institucional del 9 d\'Octubre - Dia de la Comunitat Valenciana',
                'contacto' => 'Rosa Maria Monfort (Delegació de Cultura)',
                'telefono' => '644 556 677',
                'correo' => 'cultura@castello.es',
                'dnicontacto' => '18965412G',
                'observacions' => 'Acte solemne i interpretació de l\'Himne Regional de la Comunitat Valenciana.',
                'actuaciones' => [
                    [
                        'fechaActuacion' => '2026-10-09',
                        'descripcion' => 'Concert Solemne del 9 d\'Octubre',
                        'tipo' => 'Ensayo',
                        'musicos' => 70,
                        'preciomusico' => 55.00,
                        'coches' => 12,
                        'preciocoche' => 20.00,
                        'furgonas' => 1,
                        'preciofurgona' => 35.00,
                        'oficial' => true,
                        'is_draft' => false,
                        'observaciones' => 'Presidència d\'autoritats i cloenda amb focs artificials.',
                    ],
                ],
            ],
        ];

        foreach ($contratosData as $cData) {
            $actuacionesData = $cData['actuaciones'] ?? [];
            unset($cData['actuaciones']);

            // Crear o actualizar contrato
            $contrato = Contratos::updateOrCreate(
                [
                    'poblacion' => $cData['poblacion'],
                    'anyo' => $cData['anyo'],
                ],
                $cData
            );

            foreach ($actuacionesData as $aData) {
                $tipoNombre = $aData['tipo'] ?? 'Ensayo';
                $tipoId = $getIdTipo($tipoNombre);
                unset($aData['tipo']);

                $totMusicos = ($aData['musicos'] ?? 0) * ($aData['preciomusico'] ?? 0);
                $totCoches = ($aData['coches'] ?? 0) * ($aData['preciocoche'] ?? 0);
                $totFurgos = ($aData['furgonas'] ?? 0) * ($aData['preciofurgona'] ?? 0);

                $aData['contratos_id'] = $contrato->id;
                $aData['tipoactuacions_id'] = $tipoId;
                $aData['totalmusicos'] = $totMusicos;
                $aData['totalcoches'] = $totCoches;
                $aData['totalactuacion'] = $totMusicos + $totCoches + $totFurgos;
                $aData['pagado'] = false;
                $aData['aplicaporcentaje'] = true;
                $aData['noaplicapago'] = false;
                $aData['porcentajepersonal'] = null;

                $actuacion = Actuacion::updateOrCreate(
                    [
                        'contratos_id' => $contrato->id,
                        'fechaActuacion' => $aData['fechaActuacion'],
                        'descripcion' => $aData['descripcion'],
                    ],
                    $aData
                );

                // Asegurar que la lista existe
                $lista = $actuacion->lista;
                if (! $lista) {
                    $lista = Listas::create([
                        'actuacions_id' => $actuacion->id,
                        'pagada' => 0,
                        'cuentas' => 0,
                    ]);
                }

                // Asignar entre 5 y 12 músicos a la lista para dar realismo
                if ($users->isNotEmpty() && $lista->listasUsers()->count() === 0) {
                    $musicosAsignados = $users->random(min(10, $users->count()));
                    $cocheAsignado = false;
                    $furgoAsignada = false;

                    foreach ($musicosAsignados as $index => $musico) {
                        $llevaCoche = (! $cocheAsignado && $index === 0);
                        if ($llevaCoche) {
                            $cocheAsignado = true;
                        }

                        $llevaFurgo = (! $furgoAsignada && $index === 1);
                        if ($llevaFurgo) {
                            $furgoAsignada = true;
                        }

                        $precioActo = (float) ($actuacion->preciomusico ?? 45.00);
                        $precioCoche = $llevaCoche ? (float) ($actuacion->preciocoche ?? 20.00) : 0.0;
                        $precioFurgo = $llevaFurgo ? (float) ($actuacion->preciofurgona ?? 35.00) : 0.0;

                        ListasUser::create([
                            'listas_id' => $lista->id,
                            'user_id' => $musico->id,
                            'disponible' => true,
                            'duda' => false,
                            'coche' => $llevaCoche,
                            'furgona' => $llevaFurgo,
                            'totalActo' => $precioActo,
                            'totalCoche' => $precioCoche,
                            'totalFurgo' => $precioFurgo,
                            'totalActuacion' => $precioActo + $precioCoche + $precioFurgo,
                        ]);
                    }
                }
            }
        }
    }
}
