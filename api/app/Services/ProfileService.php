<?php
namespace App\Services;

use App\Models\Profile;
use App\Repositories\ProfileRepository;
use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    private $repository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->repository = $profileRepository;
    }

    /**
     * @param mixed $model
     * @return Profile
     */
    public function save($data): Profile
    {
        DB::beginTransaction();

        $emailAvailable = $this->repository->emailIsAvailable($data['email'], isset($data['id']) ? $data['id']: null);
        if (!$emailAvailable) {
            throw new ServiceException('email-already-in-use', [ 'email' => $data['email'] ]);
        }
        
        $profile =  !isset($data['id']) ?
            $this->create($data) :
            $this->update($data);

        $this->saveExperiences($profile, $data['experiences'] ?? []);
        $this->saveKnowlogments($profile, $data['knowlogments'] ?? []);

        DB::commit();

        $profile->load(['experiences','knowlogments']);
            
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
        $profile = $this->repository->getById($data['id']);
        
        if (!$profile) {
            throw new ServiceException('not-found', [ 'id' => $data['id'] ]);
        }

        $profile->fill($data);
        $profile->save();

        return $profile;
    }

    private function saveExperiences(Profile $profile, $data)
    {
        return $this->saveRelationship($profile, 'experiences', $data);
    }

    private function saveKnowlogments(Profile $profile, $data)
    {
        return $this->saveRelationship($profile, 'knowlogments', $data);
    }

    private function saveRelationship(Profile $profile, string $key, $data)
    {
        $currentData = $profile->$key()->get();

        foreach ($currentData as $e) {
            $current = array_filter($data, function ($d) use ($e) {
                return isset($d['id']) && $d['id'] == $e->id;
            });

            if (count($current) == 0) {
                $e->delete();
                continue;
            }
            
            $e->fill($current[0]);
            $profile->$key()->save($e);
        }

        $new = array_filter($data, function ($e) {
            return  !isset($e['id']) || !$e['id'];
        });

        $profile->$key()->createMany($new);
    }
}
