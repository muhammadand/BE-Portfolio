<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel biar bersih sebelum isi
        DB::table('vendors')->truncate();

        // Data vendor
        $vendors = [
            ['name' => 'FM'],
            ['name' => 'BC'],
            ['name' => 'MM'],
            ['name' => 'TGT'],
        ];

        // Insert semua sekaligus
        $now = now();
        foreach ($vendors as &$vendor) {
            $vendor['created_at'] = $now;
            $vendor['updated_at'] = $now;
        }

        DB::table('vendors')->insert($vendors);
    }
}
