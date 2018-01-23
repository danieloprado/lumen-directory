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

    public function emailIsAvailable(string $email, int $ignoreId = null)
    {
        $query = Profile::where('email', '=', $email);

        if ($ignoreId) {
            $query = $query->where('id', '!=', $ignoreId);
        }

        return $query->count() == 0;
    }

    public function delete(int $id)
    {
        return Profile::where('id', '=', $id)->delete();
    }
}
