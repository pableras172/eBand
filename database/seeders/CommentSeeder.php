<?php

<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Actuacion;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $usuarios = User::pluck('id')->toArray();
        $actuaciones = Actuacion::pluck('id')->toArray();

        if (empty($usuarios) || empty($actuaciones)) {
            $this->command->warn('No se generaron comentarios porque no hay usuarios o actuaciones.');
            return;
        }

        foreach (range(1, 50) as $i) {
            Comment::create([
                'comment' => $faker->paragraph(),
                'inadecuado' => $faker->boolean(10), // 10% probabilidad
                'eliminado' => $faker->boolean(5),   // 5% probabilidad
                'user_id' => $faker->randomElement($usuarios),
                'actuacion_id' => $faker->randomElement($actuaciones),
                'data' => json_encode([
                    'likes' => $faker->numberBetween(0, 20),
                    'from_device' => $faker->randomElement(['web', 'android', 'ios']),
                ]),
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}

