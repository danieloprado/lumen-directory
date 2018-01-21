<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class ProfileKnowlogment extends Model
{
    protected $table = 'profile_knowlogment';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'level'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
