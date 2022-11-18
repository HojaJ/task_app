<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Temperature;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class TemperatureSeedController extends Controller
{
    protected $api_url;
    protected $api_url_api;

    public function __construct()
    {
        $this->api_url = config('openweatherapp.open_weather_api');
        $this->api_url_api = config('openweatherapp.open_weather_api_key');
    }

    public function seed_table(){

//        $city = City::where('id', 1)->first();
//        $temperature = $city->all_day_temp();
//        dd($temperature);

        try {
            $cities = City::get();
            foreach ($cities as $city){
                $url = "{$this->api_url}?units=metric&id={$city->api_city_id}&appid={$this->api_url_api}";
                $response = json_decode(file_get_contents($url), true);
                if($response['cod'] == 200){
                    $dubai_time = Carbon::createFromTimestamp($response['dt'],'UTC');
                    $dubai_time->setTimezone('Asia/Dubai');
                    Temperature::create([
                        'city_id' => $city->id,
                        'dt' =>  $response['dt'],
                        'dubai_time' => $dubai_time,
                        'condition' => $response['weather'][0]['main'],
                        'condition_icon' => $response['weather'][0]['icon'],
                        'temp' => $response['main']['temp'],
                        'feels_like_temp' => $response['main']['feels_like'],
                        'humidity' => $response['main']['humidity'],
                        'wind_speed' => $response['wind']['speed']
                    ]);
                }
            }
            return 'Success';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
