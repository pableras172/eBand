<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ConfigHelper;

class UpdateConfigCache extends Command
{
    protected $signature = 'cache:configurations';
    protected $description = 'Refresca la caché de configuraciones desde la base de datos.';

    public function handle()
    {
        ConfigHelper::refreshConfigurations();
        $this->info('Configuraciones actualizadas en caché.');
    }
}
