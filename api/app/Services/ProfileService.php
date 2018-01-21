<?php
namespace App\Services;

use App\Models\Profile;
use App\Repositories\ProfileRepository;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        
        $profile =  !isset($data['id']) ?
            $this->create($data) :
            $this->update($data);

        if (isset($data['experiences'])) {
            $this->saveExperiences($profile, $data['experiences']);
        }

        if (isset($data['knowlogments'])) {
            $profile->knowlogments()->createMany($data['knowlogments']);
        }

        DB::commit();
            
        return $profile;
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

    private function saveExperiences(Profile $profile, $data)
    {
        $experiences = array_reduce($data, function ($acc, $e) {
            $key = isset($e['id']) && $e['id'] > 0 ? 'update': 'create';
            $acc[$key][] = $e;
            return $acc;
        }, [
            'create' => [],
            'update' => []
        ]);

        foreach ($profile->experiences() as $e) {
            dd($e);
            if (!in_array($e->id, array_values($experiences['update']))) {
                $e->delete();
            }
        }

        $profile->experiences()->createMany($experiences['create']);
        $profile->experiences()->saveMany($experiences['update']);
    }
}
