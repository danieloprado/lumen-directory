<?php

use App\Services\ProfileService;
use App\Repositories\ProfileRepository;

class ProfileServiceTest extends TestCase
{
    private $profileService;

    public function setUp()
    {
        parent::setUp();
        $this->profileService = new ProfileService(new ProfileRepository());
    }

    public function testCreate()
    {
        $this->assertTrue(isset($this->profileService));
    }
}
