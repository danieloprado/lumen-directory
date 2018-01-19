<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function list(Request $request)
    {
        return response()->json($this->profileRepository->list());
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:150',
            'phone'=> 'max:11'
        ]);
    }
}
