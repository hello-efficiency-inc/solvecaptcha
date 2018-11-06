<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GeocodeController extends Controller
{
    /**
     * Login using Google
     *
     * @param Request $request
     * @return
     */
    public function geocode(Request $request) {
      $client = new Client([
          'base_uri' => 'https://geocoder.api.here.com/6.2/',
          'headers' => [
              'Accept' => 'application/json'
          ]
      ]);

      $appId = env('GEO_APP_ID');
      $appCode = env('GEO_APP_CODE');
      $response = $client->request(
        'GET',
        'geocode.json',
        [
        'query' => [
          'app_id' => $appId,
          'app_code' => $appCode,
          'searchText' => $request->get('address')
        ]
      ]);
      return json_decode($response->getBody(), true);
    }
}
