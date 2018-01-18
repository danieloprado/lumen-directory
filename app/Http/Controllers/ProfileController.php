<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;

class ProfileController extends Controller
{
    private $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function get()
    {
        return response()->json([]);
    }
}
