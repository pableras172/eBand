<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListasUser extends Model
{
    protected $table = "listas_user";
    protected $fillable = [
        'disponible',
    ];
    use HasFactory;

}
