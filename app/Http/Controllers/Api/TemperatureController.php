<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Traits\ApiResponse;
use App\Models\City;
use App\Models\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class TemperatureController extends Controller
{
    use ApiResponse;

    public function cities()
    {
        try {
            $cities = City::orderBy('created_at','ASC')->get();
            return $this->successResponse([
                'cities' => CityResource::collection($cities)
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function chart($city,$date)
    {
        try {
            $path= explode('/',request()->path());
            $chart = $path[1];

            $city = City::where('id',$city)->first();
            $temperatures = $city->tempetatures;

            $days = $temperatures->map(function($value, $key){
                return Carbon::parse($value->dubai_time)->format('Y-m-d');
            })->unique()->toArray();

            $all_day = $city->temp_by_day($date);

            $by_hour = $all_day->map(function($value, $key) use($chart){
                return round(collect($value->pluck($chart))->avg());
            });

            return $this->successResponse([
                'days' => array_values($days),
                'labels' =>  array_keys($by_hour->toArray()),
                'datasets'=> array_values($by_hour->toArray())
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
