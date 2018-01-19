<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    public function list()
    {
        return Profile::orderBy('name', 'desc')
            ->with(['experiences', 'knowlogments'])
            ->get();
    }

    public function getById(int $id)
    {
        return Profile::with(['experiences', 'knowlogments'])
                ->where('id', '=', $id)
                ->first();
    }
}
