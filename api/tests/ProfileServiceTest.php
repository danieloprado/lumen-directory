<?php

use App\Services\ProfileService;
use App\Repositories\ProfileRepository;
use App\Models\Profile;
use App\Exceptions\ServiceException;

class ProfileServiceTest extends TestCase
{
    private $profileService;

    public function setUp()
    {
        parent::setUp();
        $this->profileService = new ProfileService(new ProfileRepository());
    }

    public function testShouldCreateNewProfile()
    {
        $faker = Faker\Factory::create('pt_BR');
        $data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => substr($faker->cellphoneNumber(false), 0, 11),
            'experiences' => [
                [
                    'company' => $faker->company,
                    'started_at' => $faker->date('c', 'now'),
                    'ended_at' => null,
                    'description' => substr($faker->text, 0, 1000)
                ],
                [
                    'company' => $faker->company,
                    'started_at' => $faker->date('c', 'now'),
                    'ended_at' => null,
                    'description' => substr($faker->text, 0, 1000)
                ]
            ],
            'knowlogments' => [
                [
                    'name' => substr($faker->text, 0, 50),
                    'level' => $faker->numberBetween(1, 5)
                ]
            ]
        ];

        $result = $this->profileService->save($data);

        $this->assertInstanceOf(Profile::class, $result);
        $this->assertGreaterThan(0, $result->id);
        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['email'], $result->email);
        $this->assertEquals($data['phone'], $result->phone);
        $this->assertEquals(count($data['experiences']), count($result->experiences));
        $this->assertEquals(count($data['knowlogments']), count($result->knowlogments));
    }

    public function testShouldUpdateProfile()
    {
        $faker = Faker\Factory::create('pt_BR');
        $data = [
            'id' => 1,
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => substr($faker->cellphoneNumber(false), 0, 11),
            'experiences' => [
                [
                    'id' => 1,
                    'company' => $faker->company,
                    'started_at' => $faker->date('c', 'now'),
                    'ended_at' => null,
                    'description' => substr($faker->text, 0, 1000)
                ],
                [
                    'company' => $faker->company,
                    'started_at' => $faker->date('c', 'now'),
                    'ended_at' => null,
                    'description' => substr($faker->text, 0, 1000)
                ]
            ]
        ];

        $result = $this->profileService->save($data);

        $this->assertInstanceOf(Profile::class, $result);
        $this->assertEquals($data['id'], $result->id);
        $this->assertEquals($data['name'], $result->name);
        $this->assertEquals($data['email'], $result->email);
        $this->assertEquals($data['phone'], $result->phone);
        $this->assertEquals(count($data['experiences']), count($result->experiences));
        $this->assertEquals($data['experiences'][0]['id'], $result->experiences[0]->id);
        $this->assertGreaterThan(2, $result->experiences[1]->id);
        $this->assertEquals(0, count($result->knowlogments));
    }

    public function testShouldFailIfProfileIdIsNotValid()
    {
        try {
            $faker = Faker\Factory::create('pt_BR');
            $data = [
                'id' => 9999,
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => substr($faker->cellphoneNumber(false), 0, 11)
            ];

            $this->profileService->save($data);
            $this->fail("Should not save successfully");
        } catch (ServiceException $e) {
            $this->assertInstanceOf(ServiceException::class, $e);
            $this->assertEquals('not-found', $e->getMessage());
        }
    }

    public function testShouldFailIfEmailIsAlreadyTaken()
    {
        try {
            $faker = Faker\Factory::create('pt_BR');
            $data = [
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => substr($faker->cellphoneNumber(false), 0, 11)
            ];

            $this->profileService->save($data);
            $this->profileService->save($data);
            $this->fail("Should not save successfully");
        } catch (ServiceException $e) {
            $this->assertInstanceOf(ServiceException::class, $e);
            $this->assertEquals('email-already-in-use', $e->getMessage());
        }
    }

    public function testShouldAbleToDelete()
    {
        $this->profileService->delete(1);
        $this->assertTrue(true);
    }
}
