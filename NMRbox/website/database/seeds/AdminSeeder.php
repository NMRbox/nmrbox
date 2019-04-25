<?php

use App\User;

class AdminSeeder extends DatabaseSeeder {

	public function run()
	{
		// tables with foreign key constraints that need to be dropped simultaneously
		$tables = [
			'users',
			'roles',
			'role_users',
			'lab_role_person',
			'files'
		];

		DB::statement('TRUNCATE TABLE ' . implode(',', $tables). ';');

		$admin = Sentinel::registerAndActivate(array(
			'email'       => 'admin@admin.com',
			'password'    => "admin",
			'first_name'  => 'John',
			'last_name'   => 'Doe',
			'institution'   => 'UCHC',
		));

		$adminRole = Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'Admin',
			'slug' => 'admin',
            'permissions' => array('admin' => 1),
		]);

		Sentinel::getRoleRepository()->createModel()->create([
			'name'  => 'User',
			'slug'  => 'user',
		]);

		Sentinel::getRoleRepository()->createModel()->create([
			'name'  => 'Public',
			'slug'  => 'public',
		]);

		$admin->roles()->attach($adminRole);
	}

}