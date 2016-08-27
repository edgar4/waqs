<?php
use App\Job;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->truncate();
        $faker = Faker::create();

        for ($i = 0; $i < 1000; $i++) {

            Job::create([
                'title' => $faker->jobTitle(),
                'description' => $faker->paragraph(5),
                'raw_description' => $faker->paragraph(15),
                'salary' => $faker->numberBetween(1000, 1000000),
                'time_posted' => $faker->dateTime(),
                'location' => $faker->country(),
                'type' => $faker->word(),

            ]);

        }
    }
}
