<?php
namespace App\Services;

use App\Models\Profile;
use App\Repositories\ProfileRepository;

class ProfileService
{
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param mixed $model
     * @return Profile
     */
    public function save($data): Profile
    {
        $profile = $this->profileRepository->getById($data->id);

        return !$profile ?
            $this->create($data) :
            $this->update($profile, $data);
    }

    private function create($data)
    {
        $profile = new Profile();
        $profile->fill($data);

        return $profile;
    }

    private function update(Profile $profile, $data)
    {
        $profile->fill($model);
        $profile->save();

        return $profile;
    }
}
