<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DepartmentsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(ReasonsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(WorkSchedulesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(StatusReasonsTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(UserStatusesTableSeeder::class);
    }
}
