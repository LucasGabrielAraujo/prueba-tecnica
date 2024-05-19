<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//libreria de scraping
use Goutte\Client;

class BaScrapingController extends Controller
{
    public function climaBA(){
        try {
            //url para obtener el clima
            $url = 'https://www.tiempo.com/buenos-aires.htm';
            
            //creamos el objeto client 
            $cliente = new Client();

            //obtenemos el documento
            $crawler = $cliente->request('GET', $url);

            //filtramos por span y la clase que tiene como valor la temperatura
            $clima = $crawler->filter('span.dato-temperatura.changeUnitT')->text();
            
            //devolvemos el clima
            return response()->json($clima);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el clima: ' . $e->getMessage()], 500);
        }
    }
}
