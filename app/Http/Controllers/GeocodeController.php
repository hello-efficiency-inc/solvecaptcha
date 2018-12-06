<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\RequestStack;

class GeocodeController extends Controller
{

    public function license (Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.gumroad.com/v2/licenses/verify?product_permalink=ridereceiptspro&license_key=C296393B-26A7415E-8FB656AD-D1BEDBDD",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "undefined=",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
                "Postman-Token: 9dc42b3e-4bfe-4804-828d-3502dff83909",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
//        $client = new Client([
//            'base_uri' => 'https://api.gumroad.com/v2/',
//            'headers' => [
//                'Accept' => 'application/json',
//                'Content-Type' => 'application/x-www-form-urlencoded'
//            ]
//        ]);
//
//        $response = $client->request(
//            'POST',
//            'license/verify',
//            [
//                'query' => [
//                    'product_permalink' => $request->get('product_permalink'),
//                    'license_key' => $request->get('license_key')
//                ]
//            ]);
//        return json_decode($response->getBody(), true);
    }
    /**
     * Login using Google
     *
     * @param Request $request
     * @return
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function geocode(Request $request) {
      $cacheSlug = str_slug($request->get('address'));
      return Cache::rememberForever($cacheSlug, function () use ($request) {
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
      });
    }
}
