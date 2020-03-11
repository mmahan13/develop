<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Illuminate\Support\Collection;
use \App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use Notifiable;
   // protected $dateFormat = 'Y-m-d H:i:s.000';
    protected $appends = ['role_companies', 'expenses'];

    public $timestamps = false;
    protected $table = 'portal.users';
    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token, $this));
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rol', 'name', 'apellidos','dni', 'email','direccion', 'telefono', 'logged', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    /**
     * @param String $url
     * @return bool
     */
    public function hasPermissionForUrl(String $url)
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermissionForUrl($url)) return true;
        }
        return false;
    }

    /**
     * @param $roles string | array
     * @return bool
     */
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                foreach ($this->roles as $r) {
                    if ($r->name == $role) return true;
                };
            }
        } elseif (is_string($roles)) {
            foreach ($this->roles as $r) {
                if ($r->name == $roles) return true;
            };
        }
        return false;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRoleCompaniesAttribute()
    {
        $relation = new Collection();
        foreach ($this->roles as $role) {
            $relation->push($role->companies);
        }
        return $relation->flatten(1);
    }

    /**
     * @param $permissions
     * @return bool
     */
    public function hasPermission($permissions)
    {
        if ($this->hasRole('super')) return true;
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                foreach ($this->roles as $role) {
                    if ($role->hasModule($permission)) return true;
                }
            }
        } elseif (is_string($permissions)) {
            foreach ($this->roles as $role) {
                if ($role->hasModule($permissions)) return true;
            }
        }
        return false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function downloads()
    {
        return $this->belongsToMany(Folder::class)->withPivot('created_at');
    }

    /**
     * @param bool $status
     * @return bool
     */
    public function setLogged(bool $status)
    {
        $this->fill(['logged' => $status]);
        return $this->save();

    }

    public function getExpensesAttribute($value)
    {
        return $value;
    }

    public function setExpensesAttribute($value)
    {
        Log::debug('setExpensesAttribute');
        Log::debug($value);
        $this->attributes['expenses'] = $value;
        Log::debug('setExpensesAttribute3333');
        Log::debug($this->attributes);
    }
}
