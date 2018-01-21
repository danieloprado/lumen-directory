<?php

use App\Services\ProfileService;
use App\Repositories\ProfileRepository;
use App\Models\Profile;

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

    public function testUpdate()
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
    }
}
