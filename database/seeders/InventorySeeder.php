<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categorías de Inventario de la Agrupación
        $categoriesData = [
            'Vent Fusta' => 'Clarinet, saxòfon, flauta, oboè, fagot i altres instruments de vent fusta.',
            'Vent Metall' => 'Trompeta, trompa, trombó, bombardí, tuba i accessoris de vent metall.',
            'Percussió' => 'Timbales, plats, caixes, bombos, làmines (marimba, xilòfon) i accessoris de percussió.',
            'So i Audiovisual' => 'Altaveus, taules de mescla, micròfons, cablejat i equip de so en directe.',
            'Mobiliari i Atrils' => 'Atrils de peu, cadires, podis de director, llums i caixes de transport.',
            'Uniformitat i Arxiu' => 'Corbates, jaquetes corporatives, insígnies, carpetes de partitures i arxiu.',
        ];

        $categories = [];
        foreach ($categoriesData as $nombre => $descripcion) {
            $categories[$nombre] = InventoryCategory::query()->firstOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => $descripcion]
            );
        }

        // 2. Músicos disponibles para asignar material
        $musicians = User::query()
            ->with('instrument')
            ->whereHas('roles', fn ($q) => $q->where('title', 'User'))
            ->get();

        if ($musicians->isEmpty()) {
            $musicians = User::query()->with('instrument')->limit(12)->get();
        }

        $adminUser = User::query()
            ->whereHas('roles', fn ($q) => $q->whereIn('title', ['Admin', 'SuperAdmin']))
            ->first() ?? User::query()->first();

        $creatorId = $adminUser?->id ?? 1;

        // 3. Catálogo de elementos realistas de inventario
        $itemsData = [
            // Vent Fusta
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Clarinet en Sib Buffet Crampon E11',
                'cantidad' => 2,
                'valor_unitario' => 950.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2024,
                'purchase_date' => '2024-03-15',
                'observaciones' => 'Amb estoig rígid i boquilla Vandoren B40. En perfecte estat de sabatilles.',
                'target_instrument' => 'Clarinet',
            ],
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Clarinet Baix Yamaha YCL-221II',
                'cantidad' => 1,
                'valor_unitario' => 2450.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2023,
                'purchase_date' => '2023-09-10',
                'observaciones' => 'Cos de resina ABS amb campana niquelada. Propietat de la societat musical.',
                'target_instrument' => 'Clarinet',
            ],
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Saxòfon Alt Yamaha YAS-280',
                'cantidad' => 2,
                'valor_unitario' => 1100.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2025,
                'purchase_date' => '2025-01-20',
                'observaciones' => 'Model d\'estudiant avançat. Inclou tudell original i corretja encoixinada.',
                'target_instrument' => 'Saxofón',
            ],
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Saxòfon Tenor Yamaha YTS-280',
                'cantidad' => 1,
                'valor_unitario' => 1650.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2023,
                'purchase_date' => '2023-11-05',
                'observaciones' => 'Revisat recentment pel luthier. Lacat daurat original.',
                'target_instrument' => 'Saxofón',
            ],
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Saxòfon Baríton Jupiter JBS-1000',
                'cantidad' => 1,
                'valor_unitario' => 4200.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2022,
                'purchase_date' => '2022-04-18',
                'observaciones' => 'Amb clau de La greu i suport amb rodes per a transport.',
                'target_instrument' => 'Saxofón',
            ],
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Flauta travessera Yamaha YFL-212',
                'cantidad' => 1,
                'valor_unitario' => 620.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2025,
                'purchase_date' => '2025-02-10',
                'observaciones' => 'Plats tancats, mecanisme de Mi. Estoig i funda de transport.',
                'target_instrument' => 'Flauta',
            ],
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Oboè Yamaha YOB-241',
                'cantidad' => 1,
                'valor_unitario' => 1800.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2023,
                'purchase_date' => '2023-06-12',
                'observaciones' => 'Sistema conservatori simplificat, cos de resina.',
                'target_instrument' => 'Oboe',
            ],
            [
                'category' => 'Vent Fusta',
                'nombre' => 'Fagot Schreiber S16',
                'cantidad' => 1,
                'valor_unitario' => 5600.00,
                'estado' => 'usado',
                'depreciation_rate' => 4.00,
                'year' => 2021,
                'purchase_date' => '2021-10-30',
                'observaciones' => 'Fusta d\'auró de muntanya, 2 tudells KER22 i funda de motxilla.',
                'target_instrument' => 'Fagot',
            ],

            // Vent Metall
            [
                'category' => 'Vent Metall',
                'nombre' => 'Trompeta en Sib Bach Stradivarius 37',
                'cantidad' => 1,
                'valor_unitario' => 2950.00,
                'estado' => 'usado',
                'depreciation_rate' => 4.00,
                'year' => 2023,
                'purchase_date' => '2023-05-14',
                'observaciones' => 'Campana d\'una sola peça martellejada a mà. Acabat platejat.',
                'target_instrument' => 'Trompeta',
            ],
            [
                'category' => 'Vent Metall',
                'nombre' => 'Trompeta en Sib Yamaha YTR-2330',
                'cantidad' => 2,
                'valor_unitario' => 520.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2025,
                'purchase_date' => '2025-01-15',
                'observaciones' => 'Pistons de monel i bombes sense soldadura. Per a alumnes de l\'escola.',
                'target_instrument' => 'Trompeta',
            ],
            [
                'category' => 'Vent Metall',
                'nombre' => 'Trompa doble Sib/Fa Yamaha YHR-567',
                'cantidad' => 1,
                'valor_unitario' => 3450.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2022,
                'purchase_date' => '2022-11-20',
                'observaciones' => 'Campana desmuntable i vàlvules rotatives d\'alta precisió.',
                'target_instrument' => 'Trompa',
            ],
            [
                'category' => 'Vent Metall',
                'nombre' => 'Trombó de vares Yamaha YSL-354',
                'cantidad' => 2,
                'valor_unitario' => 890.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2024,
                'purchase_date' => '2024-04-05',
                'observaciones' => 'Vara niquelada de lliscament suau. Inclou boquilla 48.',
                'target_instrument' => 'Trombón',
            ],
            [
                'category' => 'Vent Metall',
                'nombre' => 'Bombardí Besson New Standard 3 pistons',
                'cantidad' => 1,
                'valor_unitario' => 1750.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2023,
                'purchase_date' => '2023-08-19',
                'observaciones' => 'Bany platejat amb xicotet senyal d\'ús en la corba inferior.',
                'target_instrument' => 'Bombardino',
            ],
            [
                'category' => 'Vent Metall',
                'nombre' => 'Tuba en Sib Yamaha YBB-321',
                'cantidad' => 1,
                'valor_unitario' => 6200.00,
                'estado' => 'usado',
                'depreciation_rate' => 4.00,
                'year' => 2022,
                'purchase_date' => '2022-02-11',
                'observaciones' => '4 pistons superiors, campana ampla de 443 mm. Estoig rígid amb rodes.',
                'target_instrument' => 'Tuba',
            ],

            // Percussió
            [
                'category' => 'Percussió',
                'nombre' => 'Timbales simfòniques Adams Professional (Joc de 4)',
                'cantidad' => 1,
                'valor_unitario' => 8500.00,
                'estado' => 'usado',
                'depreciation_rate' => 4.00,
                'year' => 2021,
                'purchase_date' => '2021-06-01',
                'observaciones' => 'Mesures 23", 26", 29" i 32". Calderes parabòliques de coure polides.',
                'target_instrument' => 'Percusión',
            ],
            [
                'category' => 'Percussió',
                'nombre' => 'Bombo de concert Adams 36" amb suport oscil·lant',
                'cantidad' => 1,
                'valor_unitario' => 1950.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2023,
                'purchase_date' => '2023-03-22',
                'observaciones' => 'Cèrcols de fusta d\'auró i rodament oscil·lant de 360 graus.',
                'target_instrument' => null, // Col·lectiu a la seu
            ],
            [
                'category' => 'Percussió',
                'nombre' => 'Plats de xoc Zildjian Avedis 18" Concert Stage',
                'cantidad' => 1,
                'valor_unitario' => 640.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2024,
                'purchase_date' => '2024-05-18',
                'observaciones' => 'Amb corretges de cuir professionals i coixinets protectores.',
                'target_instrument' => 'Percusión',
            ],
            [
                'category' => 'Percussió',
                'nombre' => 'Caixa Pearl Philharmonic 14x5" d\'alumini',
                'cantidad' => 2,
                'valor_unitario' => 780.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2024,
                'purchase_date' => '2024-10-10',
                'observaciones' => 'Triple bordoner ajustable SR-500. Pelfes Evans Strata 1000.',
                'target_instrument' => 'Percusión',
            ],
            [
                'category' => 'Percussió',
                'nombre' => 'Marimba Adams Concert 4.3 octaves',
                'cantidad' => 1,
                'valor_unitario' => 4800.00,
                'estado' => 'usado',
                'depreciation_rate' => 4.00,
                'year' => 2022,
                'purchase_date' => '2022-07-25',
                'observaciones' => 'Làmines de fusta de palorosa d\'Hondures. Suport regulable Voyager.',
                'target_instrument' => null, // Col·lectiu
            ],
            [
                'category' => 'Percussió',
                'nombre' => 'Bateria acústica Yamaha Stage Custom Birch',
                'cantidad' => 1,
                'valor_unitario' => 1250.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2023,
                'purchase_date' => '2023-04-12',
                'observaciones' => 'Set de 5 peces amb ferratges Yamaha 700 series (sense plats).',
                'target_instrument' => 'Batería',
            ],

            // So i Audiovisual
            [
                'category' => 'So i Audiovisual',
                'nombre' => 'Altaveus autoamplificats JBL EON 715 (Parella)',
                'cantidad' => 2,
                'valor_unitario' => 560.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 10.00,
                'year' => 2025,
                'purchase_date' => '2025-01-08',
                'observaciones' => '1300W de pic, Bluetooth 5.0, DSP integrat. Inclou peus d\'altaveu.',
                'target_instrument' => null,
            ],
            [
                'category' => 'So i Audiovisual',
                'nombre' => 'Taula de mescles Behringer Xenyx X2442USB',
                'cantidad' => 1,
                'valor_unitario' => 380.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 10.00,
                'year' => 2024,
                'purchase_date' => '2024-09-15',
                'observaciones' => '24 entrades, 4 subgrups, interfície d\'àudio USB i processador d\'efectes.',
                'target_instrument' => null,
            ],
            [
                'category' => 'So i Audiovisual',
                'nombre' => 'Micròfons dinàmics Shure SM58 amb suports',
                'cantidad' => 4,
                'valor_unitario' => 115.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 10.00,
                'year' => 2024,
                'purchase_date' => '2024-11-20',
                'observaciones' => 'Càpsula cardioide per a veu i solistes. Cables XLR de 10 metres inclosos.',
                'target_instrument' => null,
            ],

            // Mobiliari i Atrils
            [
                'category' => 'Mobiliari i Atrils',
                'nombre' => 'Atrils metàl·lics de peu negres plegables Manhasset',
                'cantidad' => 45,
                'valor_unitario' => 42.00,
                'estado' => 'usado',
                'depreciation_rate' => 5.00,
                'year' => 2023,
                'purchase_date' => '2023-01-20',
                'observaciones' => 'Atrils simfònics robustos per a escenari i assaigs.',
                'target_instrument' => null,
            ],
            [
                'category' => 'Mobiliari i Atrils',
                'nombre' => 'Podi i atril gran de director Konig & Meyer',
                'cantidad' => 1,
                'valor_unitario' => 490.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2024,
                'purchase_date' => '2024-02-14',
                'observaciones' => 'Podi de fusta antilliscant i atril de doble safata per a partitures grans.',
                'target_instrument' => null,
            ],
            [
                'category' => 'Mobiliari i Atrils',
                'nombre' => 'Llums LED per a atril amb bateria Mighty Bright',
                'cantidad' => 35,
                'valor_unitario' => 22.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 10.00,
                'year' => 2024,
                'purchase_date' => '2024-06-05',
                'observaciones' => 'Bateria recarregable USB per a concerts a l\'aire lliure o de nit.',
                'target_instrument' => null,
            ],

            // Uniformitat i Arxiu
            [
                'category' => 'Uniformitat i Arxiu',
                'nombre' => 'Carpetes de carrer negres per a partitures en marxa',
                'cantidad' => 60,
                'valor_unitario' => 12.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2024,
                'purchase_date' => '2024-02-28',
                'observaciones' => 'Carpetes rígides amb el logotip de la banda en lletres daurades.',
                'target_instrument' => null,
            ],
            [
                'category' => 'Uniformitat i Arxiu',
                'nombre' => 'Joc de corbates corporatives i insígnies de la banda',
                'cantidad' => 75,
                'valor_unitario' => 18.00,
                'estado' => 'nuevo',
                'depreciation_rate' => 5.00,
                'year' => 2025,
                'purchase_date' => '2025-01-10',
                'observaciones' => 'Teixit de seda blau marí amb escut brodat.',
                'target_instrument' => null,
            ],
        ];

        // 4. Inserció o actualització d'items
        $assignedUserIds = [];

        foreach ($itemsData as $data) {
            $cat = $categories[$data['category']] ?? null;
            if (! $cat) {
                continue;
            }

            /** @var InventoryItem $item */
            $item = InventoryItem::query()->firstOrCreate(
                ['nombre' => $data['nombre']],
                [
                    'inventory_category_id' => $cat->id,
                    'year' => $data['year'],
                    'cantidad' => $data['cantidad'],
                    'valor_unitario' => $data['valor_unitario'],
                    'estado' => $data['estado'],
                    'observaciones' => $data['observaciones'],
                    'depreciation_rate' => $data['depreciation_rate'],
                    'purchase_date' => $data['purchase_date'],
                ]
            );

            // Determinar responsable segons instrument si escau
            $matchedUser = null;
            if (! empty($data['target_instrument']) && $musicians->isNotEmpty()) {
                $target = mb_strtolower($data['target_instrument']);
                $matchedUser = $musicians->first(function (User $u) use ($target) {
                    $instName = mb_strtolower($u->instrument?->name ?? '');

                    return str_contains($instName, $target);
                });

                if (! $matchedUser) {
                    // Si no troba coincidència exacta, agafar un músic no saturat
                    $matchedUser = $musicians->random();
                }
            }

            if ($matchedUser && ! $item->responsables()->where('users.id', $matchedUser->id)->exists()) {
                $item->responsables()->attach($matchedUser->id);
                $assignedUserIds[] = $matchedUser->id;
            }

            // Crear moviment inicial si no existeix
            if ($item->movements()->count() === 0) {
                InventoryMovement::create([
                    'inventory_item_id' => $item->id,
                    'user_id' => $creatorId,
                    'tipo' => 'compra',
                    'descripcion' => 'Alta i registre inicial de l\'element en l\'inventari de la societat.',
                    'created_at' => Carbon::parse($data['purchase_date'])->setTime(10, 0),
                ]);
            }
        }
    }
}
