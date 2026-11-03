<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class DemoAccessLead extends Model
{
    use CentralConnection;
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'ip_address',
        'user_agent',
        'lead_type',
        'source',
        'entidad',
        'municipio',
        'telefono_contacto',
        'mensaje',
    ];
}
