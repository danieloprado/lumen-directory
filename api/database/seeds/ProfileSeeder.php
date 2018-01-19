<?php

use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('profile')->count();

        if ($count > 0) {
            return;
        }

        $faker = Faker\Factory::create('pt_BR');

        DB::table('profile')->insert([
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => substr($faker->cellphoneNumber(false), 0, 11),
            'created_at'=> date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);

        DB::table('profile_experience')->insert([
            'profile_id' => 1,
            'company' => 'Empresa',
             'started_at' => '2017-01-01',
             'ended_at' => null,
             'description' => 'Web/Mobile Developer'
        ]);

        DB::table('profile_knowlogment')->insert([
            'profile_id' => 1,
            'name' => 'Javascript',
            'level' => 5
        ]);

        DB::table('profile_knowlogment')->insert([
            'profile_id' => 1,
            'name' => 'Inglês',
            'level' => 3
        ]);
    }
}
