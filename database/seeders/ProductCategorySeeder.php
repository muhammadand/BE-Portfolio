<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan dulu tabel biar aman
        DB::table('product_categories')->truncate();

        // Data parent categories
        $parents = [
            ['name' => 'eSIM', 'slug' => Str::slug('eSim')],
            ['name' => 'SIM Card', 'slug' => Str::slug('SIM Card')],
        ];

        // Simpan parent dan ambil ID-nya
        $parentIds = [];
        foreach ($parents as $parent) {
            $id = DB::table('product_categories')->insertGetId([
                'parent_id'   => null,
                'name'        => $parent['name'],
                'slug'        => $parent['slug'],
                'description' => $parent['name'] . ' main category',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            $parentIds[$parent['name']] = $id;
        }

        // Data child categories
        $children = [
            ['name' => 'eSIM A', 'parent' => 'eSIM'],
            ['name' => 'eSIM B', 'parent' => 'eSIM'],
            ['name' => 'SIM Card A', 'parent' => 'SIM Card'],
            ['name' => 'SIM Card B', 'parent' => 'SIM Card'],
        ];

        foreach ($children as $child) {
            DB::table('product_categories')->insert([
                'parent_id'   => $parentIds[$child['parent']],
                'name'        => $child['name'],
                'slug'        => Str::slug($child['name']),
                'description' => $child['name'] . ' sub category',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
