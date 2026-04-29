<?php

namespace App\Console\Commands\Tenancy;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Stancl\Tenancy\Database\Models\Domain;

class CreateTenantCommand extends Command
{
    protected $signature = 'tenancy:create-tenant
        {id : Identificador del tenant (ej: banda-municipal)}
        {name : Nombre del grupo}
        {code : Código de acceso inicial del grupo}
        {domain : Dominio o subdominio del tenant (ej: banda.localhost)}';

    protected $description = 'Crea un tenant, su base de datos y su dominio principal.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $tenantId = (string) $this->argument('id');
        $name = (string) $this->argument('name');
        $code = (string) $this->argument('code');
        $domain = (string) $this->argument('domain');

        $tenantExists = Tenant::query()
            ->where('id', $tenantId)
            ->orWhere('code', $code)
            ->exists();

        if ($tenantExists) {
            $this->error('Ya existe un tenant con ese id o código.');

            return self::FAILURE;
        }

        $domainAlreadyInUse = Domain::query()
            ->where('domain', $domain)
            ->exists();

        if ($domainAlreadyInUse) {
            $this->error('Ese dominio ya está asignado a otro tenant.');

            return self::FAILURE;
        }

        $tenant = Tenant::query()->create([
            'id' => $tenantId,
            'name' => $name,
            'code' => $code,
        ]);

        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        $this->info('Tenant creado correctamente.');
        $this->line('ID: '.$tenant->id);
        $this->line('Código: '.$tenant->code);
        $this->line('Dominio: '.$domain);

        return self::SUCCESS;
    }
}
