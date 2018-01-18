<?php

namespace App\Models;

use App\Models\ProfileExperience;
use App\Models\ProfileKnowlogment;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone'
    ];

    public function experiences()
    {
        return $this->hasMany(ProfileExperience::class);
    }

    public function knowlogments()
    {
        return $this->hasMany(ProfileKnowlogment::class);
    }
}
