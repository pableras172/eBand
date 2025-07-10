<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'instrument_id',
        'telefono',
        'porcentaje',
        'forastero',
        'observaciones',
        'fechaAlta',
        'activo',
        'uuid',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (!$user->roles()->get()->contains(2)) {
                $user->roles()->attach(2);
            }
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function instrument()
    {
        return $this->belongsTo('App\Models\Instrument');
    }

    public function listas()
    {
        return $this->belongsToMany(Listas::class, 'listas_user', 'user_id', 'listas_id')
            ->withPivot('coche', 'pagada', 'cuentas', 'disponible'); // También puedes incluir timestamps si los tienes en la tabla pivot
    }

    public function hasRole($role)
    {

        return $this->roles()->where('title', $role)->exists();
    }


    public function listasUsers()
    {
        return $this->hasMany(ListasUser::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function comments()
    {
        return $this->belongsTo(Comment::class, 'user_id');
    }


    public function hijos()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function padre()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

}
