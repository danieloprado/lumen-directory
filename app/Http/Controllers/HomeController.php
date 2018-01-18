<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;

class HomeController extends Controller
{
    private $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function version()
    {
        return response()->json($this->profileService->get(1));
    }
}
