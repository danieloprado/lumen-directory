<?php
namespace App\Services;

use App\Models\Profile;
use App\Repositories\ProfileRepository;
use App\Exceptions\ServiceException;

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
        return !isset($data['id']) ?
            $this->create($data) :
            $this->update($data);
    }

    private function create($data): Profile
    {
        $profile = new Profile();
        $profile->fill($data);
        $profile->save();

        return $profile;
    }

    private function update($data): Profile
    {
        $profile = $this->profileRepository->getById($data['id']);
        
        if (!$profile) {
            throw new ServiceException('not-found', [ 'id' => $data['id'] ]);
        }

        $profile->fill($data);
        $profile->save();

        return $profile;
    }
}
