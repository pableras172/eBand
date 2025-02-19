<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['comment','user_id','data', 'actuacion_id','eliminado','inadecuado','created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function actuacion()
    {
        return $this->belongsTo(Actuacion::class, 'actuacion_id');
    }

}
