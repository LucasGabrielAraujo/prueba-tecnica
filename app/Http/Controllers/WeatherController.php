<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $query = $request->query('query');
        $weather = Weather::where('city', $query)->first();
        $diff = null;

        if ($weather) {
            // hora actual
            $now = Carbon::now();
            // parsear la hora del registro de la base de datos
            $updated_at = Carbon::parse($weather->updated_at);
            // calcular la diferencia entre las horas actual y la ultima vez que se actualizo el registro
            $diff = $this->calculateHourDifference($now, $updated_at);
            // si paso 1 hora se volvera a hacer la peticion a WeatherStack
            //dd($diff);
            if ($diff < 1) {
                return response()->json($weather);
            }
        }
        $apiKey = env('WEATHERSTACK_API_KEY');
        $url = "http://api.weatherstack.com/current?access_key=$apiKey&query=$query";
        $response = Http::get($url);

        //si hay algun error con la peticion devuelve error
        if ($response->failed()) {
            return response()->json(['error' => 'No se pudo obtener el clima'], 500);
        }


        $data = $response->json();
        $cityName = $data['location']['name'];
        
        //forzar actualizacion en la base de datos
        $weather = Weather::updateOrCreate(
            ['city' => $cityName], // condicion para actualizar o crear
            [
                'data' => json_encode($data['current']),
                'updated_at' => Carbon::now()
                
            ]
        );
        

        //guardar
        return response()->json($weather);
    }
    public function calculateHourDifference($date1, $date2)
    {
    // convertir las fechas en horas
    $date1 = Carbon::parse($date1)->hour;
    $date2 = Carbon::parse($date2)->hour;
    
    // calcular la diferencia entre horas
    $diffInHours = $date1 - $date2 ;
    return $diffInHours;
    }
}