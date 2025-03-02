<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Helpers\ConfigHelper;

class Configuration extends Model
{
    use HasFactory;

    protected $table = 'configuration';

    protected $fillable = ['param', 'value', 'help'];

    protected static function booted()
    {
        static::saved(fn () => ConfigHelper::refreshConfigurations());
        static::deleted(fn () => ConfigHelper::refreshConfigurations());
    }
}
