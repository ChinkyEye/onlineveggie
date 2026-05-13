<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Baseline fixed data (branch, address, admin user only).
        $this->call(UsersTableSeeder::class);

        // Parametric benchmark dataset (catalog/users/inventory).
        // Run on its own with:
        //   BENCHMARK_SIZE=1000 php artisan db:seed --class=BenchmarkSeeder
        // $this->call(BenchmarkSeeder::class);
    }
}
