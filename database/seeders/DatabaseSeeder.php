<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
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
        $cities = config('openweatherapp.open_weather_cities');
        foreach ($cities as $key => $city){
            City::create([
                'api_city_id' => $city['id'],
                'name' => $key,
                'country_code' => $city['country'],
                'coord_lon' => $city['coord']['lon'],
                'coord_lat' => $city['coord']['lat']
            ]);
        }
    }
}
