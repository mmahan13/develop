<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Role extends Model
{
    protected $dateFormat = 'Y-m-d H:i:s.000';
    protected $fillable = ['name', 'description'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @param String $url
     * @return boolean
     */
    public function hasPermissionForUrl(String $url)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->route == $url) return true;
            if (starts_with($url, $permission->route) !== false) return true;
        }
        return false;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasModule(string $name)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->module === $name) return true;
        }
        return false;
    }


}
