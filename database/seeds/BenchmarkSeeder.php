<?php

use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * BenchmarkSeeder
 *
 * Parametric seeder for the Laravel-vs-CodeIgniter dissertation benchmark
 * (see docs/answers.txt, RSQ2). Generates 10 / 100 / 500 / 1000 catalog
 * rows (and supporting users, purchases, inventory) so JMeter can issue
 * identical workloads against both frameworks.
 *
 * Size is picked, in order of precedence:
 *   1. BENCHMARK_SIZE env var          (e.g. BENCHMARK_SIZE=500)
 *   2. SEED_SIZE env var               (alias)
 *   3. self::DEFAULT_SIZE              (1000)
 *
 * Allowed sizes: 10, 100, 500, 1000  (any other value is rejected to keep
 * benchmark results comparable across runs).
 *
 * Run:
 *   composer dump-autoload
 *   BENCHMARK_SIZE=10   php artisan db:seed --class=BenchmarkSeeder
 *   BENCHMARK_SIZE=100  php artisan db:seed --class=BenchmarkSeeder
 *   BENCHMARK_SIZE=500  php artisan db:seed --class=BenchmarkSeeder
 *   BENCHMARK_SIZE=1000 php artisan db:seed --class=BenchmarkSeeder
 */
class BenchmarkSeeder extends Seeder
{
    const DEFAULT_SIZE = 1000;
    const ALLOWED_SIZES = [10, 100, 500, 1000];

    /** Customer pool size used for RSQ1 (Register/Login) and order ownership. */
    const CUSTOMER_USERS = 100;

    /** Insert batch size — keeps memory flat for the 1000-row run. */
    const CHUNK = 200;

    public function run()
    {
        $size = $this->resolveSize();
        $faker = FakerFactory::create('en_GB');
        $faker->seed(20260513); // deterministic — same data on every run

        $this->command->info("BenchmarkSeeder: target catalog size = {$size}");

        $this->truncate();

        $now = now();
        $branchId  = $this->seedBranch($now);
        $addressId = $this->seedAddress($now);
        // Admin must exist BEFORE categories/units — their `created_by`
        // column has a FK to users.id.
        $adminId = $this->seedAdmin($branchId, $addressId, $now);
        $categoryIds = $this->seedCategories($adminId, $now);
        $unitIds = $this->seedUnits($adminId, $now);
        $customerIds = $this->seedCustomers($faker, $branchId, $addressId, $adminId, $now);
        $vegetableIds = $this->seedVegetables($faker, $categoryIds, $adminId, $size, $now);
        $purchaseIds = $this->seedPurchases($faker, $vegetableIds, $categoryIds, $unitIds, $adminId, $now);
        $this->seedPurchaseManages($faker, $purchaseIds, $unitIds, $adminId, $now);

        $this->command->info(sprintf(
            'BenchmarkSeeder: done. vegetables=%d purchases=%d customers=%d',
            count($vegetableIds),
            count($purchaseIds),
            count($customerIds)
        ));
    }

    private function resolveSize()
    {
        $raw = getenv('BENCHMARK_SIZE') ?: getenv('SEED_SIZE') ?: self::DEFAULT_SIZE;
        $size = (int) $raw;

        if (!in_array($size, self::ALLOWED_SIZES, true)) {
            throw new \InvalidArgumentException(
                "Invalid BENCHMARK_SIZE={$raw}. Allowed: " . implode(',', self::ALLOWED_SIZES)
            );
        }
        return $size;
    }

    private function truncate()
    {
        Schema::disableForeignKeyConstraints();
        foreach ([
            'carts', 'orders', 'order_totals',
            'purchase_has_outs', 'purchase_has_manages', 'purchases',
            'vegetables', 'unit_has_converts', 'units', 'categories',
            'users', 'addresses', 'branches',
        ] as $t) {
            if (Schema::hasTable($t)) {
                DB::table($t)->truncate();
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    private function seedBranch($now)
    {
        return DB::table('branches')->insertGetId([
            'name' => 'Main Branch', 'is_active' => 1,
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }

    private function seedAddress($now)
    {
        return DB::table('addresses')->insertGetId([
            'name' => 'London', 'is_active' => 1,
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }

    private function seedCategories($adminId, $now)
    {
        $rows = [
            ['name' => 'Vegetables', 'slug' => 'vegetables'],
            ['name' => 'Oil',        'slug' => 'oil'],
            ['name' => 'Fruit',      'slug' => 'fruit'],
            ['name' => 'Salad',      'slug' => 'salad'],
            ['name' => 'Beans',      'slug' => 'beans'],
        ];
        $ids = [];
        foreach ($rows as $r) {
            $ids[] = DB::table('categories')->insertGetId(array_merge($r, [
                'is_active' => 1, 'created_by' => $adminId, 'updated_by' => null,
                'created_at' => $now, 'updated_at' => $now,
            ]));
        }
        return $ids;
    }

    private function seedUnits($adminId, $now)
    {
        $rows = [['Packet','packet'], ['Litre','litre'], ['Kg','kg'], ['Gram','gram']];
        $ids = [];
        foreach ($rows as [$name, $slug]) {
            $ids[] = DB::table('units')->insertGetId([
                'name' => $name, 'slug' => $slug, 'parent_id' => 0,
                'is_active' => 1, 'created_by' => $adminId, 'updated_by' => null,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
        return $ids;
    }

    private function seedAdmin($branchId, $addressId, $now)
    {
        return DB::table('users')->insertGetId([
            'name' => 'admin', 'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'phone_no' => '', 'branch_id' => $branchId, 'address_id' => $addressId,
            'user_type' => 1, 'type' => 0, 'is_active' => 1, 'created_by' => null,
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }

    private function seedCustomers($faker, $branchId, $addressId, $adminId, $now)
    {
        $rows = [];
        $password = Hash::make('password');
        for ($i = 1; $i <= self::CUSTOMER_USERS; $i++) {
            $rows[] = [
                'name' => $faker->name,
                'email' => "customer{$i}@bench.test",
                'password' => $password,
                'phone_no' => $faker->numerify('07#########'),
                'branch_id' => $branchId, 'address_id' => $addressId,
                'user_type' => 2, 'type' => 1, 'is_active' => 1,
                'created_by' => $adminId,
                'created_at' => $now, 'updated_at' => $now,
            ];
        }

        $ids = [];
        foreach (array_chunk($rows, self::CHUNK) as $chunk) {
            DB::table('users')->insert($chunk);
        }
        $ids = DB::table('users')->where('email', 'like', 'customer%@bench.test')->pluck('id')->all();
        return $ids;
    }

    private function seedVegetables($faker, $categoryIds, $adminId, $size, $now)
    {
        $rows = [];
        for ($i = 1; $i <= $size; $i++) {
            $name = strtoupper($faker->unique()->words(2, true));
            $rows[] = [
                'display_name' => $name,
                'slug'         => str_slug($name) . '-' . $i,
                'category_id'  => $categoryIds[array_rand($categoryIds)],
                'image'        => null,
                'is_active'    => 1,
                'created_by'   => $adminId,
                'updated_by'   => null,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }
        foreach (array_chunk($rows, self::CHUNK) as $chunk) {
            DB::table('vegetables')->insert($chunk);
        }
        return DB::table('vegetables')->pluck('id')->all();
    }

    private function seedPurchases($faker, $vegetableIds, $categoryIds, $unitIds, $adminId, $now)
    {
        $rows = [];
        $date = date('Y/m/d');
        foreach ($vegetableIds as $idx => $vegId) {
            $weight = $faker->numberBetween(5, 100);
            $rate   = $faker->numberBetween(1, 200);
            $rows[] = [
                'purchase_id'      => "bench-{$vegId}-{$date}",
                'date'             => $date,
                'weight'           => (string) $weight,
                'amount'           => (string) $rate,
                'total'            => (string) ($weight * $rate),
                'vegetable_id'     => $vegId,
                'purchase_user_id' => $adminId,
                'category_id'      => $categoryIds[array_rand($categoryIds)],
                'unit_id'          => $unitIds[array_rand($unitIds)],
                'is_active'        => 1,
                'is_out'           => 0,
                'created_by'       => $adminId,
                'updated_by'       => null,
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }
        foreach (array_chunk($rows, self::CHUNK) as $chunk) {
            DB::table('purchases')->insert($chunk);
        }
        return DB::table('purchases')->pluck('id')->all();
    }

    private function seedPurchaseManages($faker, $purchaseIds, $unitIds, $adminId, $now)
    {
        $rows = [];
        $date = date('Y/m/d');
        foreach ($purchaseIds as $pid) {
            $rows[] = [
                'purchase_id' => $pid,
                'weight'      => (string) $faker->numberBetween(1, 50),
                'unit_id'     => $unitIds[array_rand($unitIds)],
                'rate'        => (string) $faker->numberBetween(1, 200),
                'date'        => $date,
                'is_active'   => 1,
                'created_by'  => $adminId,
                'updated_by'  => null,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }
        foreach (array_chunk($rows, self::CHUNK) as $chunk) {
            DB::table('purchase_has_manages')->insert($chunk);
        }
    }
}
