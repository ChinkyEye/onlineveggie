<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branchId = DB::table('branches')->insertGetId([
            'name' => 'Main Branch',
            'is_active' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        // 2. Create Address
        $addressId = DB::table('addresses')->insertGetId([
            'name' => 'London',
            'is_active' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        // 3. Create Staff User (NO MANAGER)
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'user_type' => 1, // employee
            'type' => 0, // employee
            'is_active' => 1,
            'branch_id' => $branchId,
            'address_id' => $addressId,
            'password' => Hash::make('admin123'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
