<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class ProfileExperience extends Model
{
    protected $table = 'profile_experience';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company', 'started_at', 'ended_at', 'description'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
