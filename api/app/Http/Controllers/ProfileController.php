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

    public function get(int $id)
    {
        return response()->json($this->profileRepository->getById($id));
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'id' => 'integer|min:1',
            'name' => 'required|max:100',
            'email' => 'required|email|max:150',
            'phone'=> 'max:11',
            'experiences' => 'array',
            'experiences.*.id' => 'integer|min:1',
            'experiences.*.company' => 'required|max:100',
            'experiences.*.started_at' => 'required|date',
            'experiences.*.ended_at' => 'date|after:experiences.*.started_at',
            'experiences.*.description' => 'required|max:1000',
            'knowlogments' => 'array',
            'knowlogments.*.id' => 'integer|min:1',
            'knowlogments.*.name' => 'required|max:50',
            'knowlogments.*.level' => 'integer|required|between:1,5',
        ]);

        $result = $this->profileService->save($request->all());
        return response()->json($result);
    }

    public function delete(int $id)
    {
        $this->profileService->delete($id);
    }
}
