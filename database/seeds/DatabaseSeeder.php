<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Privelege;
use App\News;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('UserTableSeeder');
		$this->command->info('User table seeded!');

		$this->call('PrivelegeTableSeeder');
		$this->command->info('Privelege table seeded!');

		$this->call('UserPrivelegePivotTableSeeder');
		$this->command->info('User Privelege pivot table seeded!');

		$this->call('NewsSeeder');
		$this->command->info('News added!');

	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create([
        	'name' => 'Dennis Kievits',
        	'email' => 'denkievits@gmail.com',
        	'password' => Hash::make('qwerty12'),
        	'slug' => 'dennis-kievits'
        ]);  

        User::create([
        	'name' => 'Vincent van Wijk',
        	'email' => 'vincentvanwijk@hotmail.nl',
        	'password' => Hash::make('qwerty12'),
        	'slug' => 'vincent-van-wijk'
        ]);

        User::create([
        	'name' => 'Dummy Student',
        	'email' => 'dummystudent@example.com',
        	'password' => Hash::make('dummy'),
        	'slug' => 'dummy-student'
        ]);

        User::create([
        	'name' => 'Dummy Student 2',
        	'email' => 'dummystudent2@example.com',
        	'password' => Hash::make('dummy'),
        	'slug' => 'dummy-student-2'
        ]);

        User::create([
        	'name' => 'Dummy Student 3',
        	'email' => 'dummystudent3@example.com',
        	'password' => Hash::make('dummy'),
        	'slug' => 'dummy-student-3'
        ]);
    }
}

class PrivelegeTableSeeder extends Seeder {

	public function run()
	{
		DB::table('priveleges')->delete();
		Privelege::create([
			'name' => 'User',
			'description' => 'A standard user with no special permissions'
		]);
		Privelege::create([
			'name' => 'Student',
			'description' => 'A student that has the student permissions'
		]);
		Privelege::create([
			'name' => 'Moderator',
			'description' => 'A moderator that is mostly used for content management'
		]);
		Privelege::create([
			'name' => 'Administrator',
			'description' => 'An administrator used for administrative task such as user management'
		]);
	}

}

class UserPrivelegePivotTableSeeder extends Seeder {

	public function run()
	{
		DB::table('user_privelege')->delete();

		// Dennis Kievits
		$user = User::where('name', 'Dennis Kievits')->first();
		$id = Privelege::where('name', 'Administrator')->first()->id;
        if (!$id) {
        	$this->command->info('Administrator privelege can\'t be found.');
        } else {
        	$user->priveleges()->attach($id);
        }

        // Vincent van Wijk
        $user = User::where('name', 'Vincent van Wijk')->first();
        $id = Privelege::where('name', 'Administrator')->first()->id;

        if (!$id) {
        	$this->command->info('Administrator privelege can\'t be found.');
        } else {
        	$user->priveleges()->attach($id);
        }

        // Dummy Student
        $user = User::where('name', 'Dummy Student')->first();
        $id = Privelege::where('name', 'Student')->first()->id;

        if (!$id) {
        	$this->command->info('Student privelege can\'t be found.');
        } else {
        	$user->priveleges()->attach($id);
        }

        // Dummy Student
        $user = User::where('name', 'Dummy Student 2')->first();
        $id = Privelege::where('name', 'Student')->first()->id;

        if (!$id) {
        	$this->command->info('Student privelege can\'t be found.');
        } else {
        	$user->priveleges()->attach($id);
        }

        // Dummy Student
        $user = User::where('name', 'Dummy Student 3')->first();
        $id = Privelege::where('name', 'Student')->first()->id;

        if (!$id) {
        	$this->command->info('Student privelege can\'t be found.');
        } else {
        	$user->priveleges()->attach($id);
        }



	}

}

class NewsSeeder extends Seeder {

	public function run()
	{
		DB::table('news')->delete();
		News::create([
			'title' => 'Test Artikel1',
			'content' => 'Dit is een test artikel dat geen gebruik maakt van html tags! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat vitae, quibusdam eius deserunt, consequuntur possimus hic voluptatum incidunt soluta temporibus quam architecto sint ad animi vel aperiam assumenda debitis. Quae.',
			'slug' => 'test-artikel1'
		]);
		News::create([
			'title' => 'Test Artikel2',
			'content' => '<span style="color: red;">Dit artikel</span> maakt gebruikt van <h3>tags.</h3>',
			'slug' => 'test-artikel2'
		]);
	}

}