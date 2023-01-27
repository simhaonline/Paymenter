<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'companyname',
        'permissions',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin',
        'permissions',
        'api_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array'
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class, 'user', 'id');
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'client', 'id');
    }
    
    public function invoices()
    {
        return $this->hasMany(Invoices::class, 'user_id', 'id');
    }

    public function has($permission)
    {
        if(!$this->permissions && $this->is_admin == 1) {
            return true;
        }
        // Check if array contains permission
        if (in_array($permission, $this->permissions)) {
            return true;
        }
        return false;
    }
}
