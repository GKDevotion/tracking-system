<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/countries.json'));
        $countries = json_decode($json, true);

        $data = [];

        foreach ($countries as $country) {
            $data[] = [
                'sortname' => $country['sortname'] ?? '',
                'sort_description' => $country['sort_description'] ?? '',
                'name' => $country['name'] ?? '',
                'symbol' => $country['symbol'] ?? '',
                'code' => $country['code'] ?? '0',
                'image' => null,
                'flag' => null,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('countries')->insertOrIgnore($data);
    }
}
