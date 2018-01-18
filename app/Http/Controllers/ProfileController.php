<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;
use App\Repositories\ProfileRepository;

class ProfileController extends Controller
{
    private $profileService;
    private $profileRepository;

    public function __construct(ProfileService $profileService, ProfileRepository $profileRepository)
    {
        $this->profileService = $profileService;
        $this->profileRepository = $profileRepository;
    }

    public function list()
    {
        return response()->json($this->profileRepository->list());
    }
}
