<?php namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * Class CaptchaController
 * @package App\Http\Controllers
 */
class CaptchaController extends Controller
{

    /**
     * Get Token
     *
     * @param $captcha
     * @return mixed
     */
    public function getToken($captcha) {

        $client = new Client([
            'base_uri' => 'http://api.dbcapi.me/api/',
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $response = $client->get('captcha/'.$captcha);

        return json_decode($response->getBody(), true);
    }
    /**
     * Solve the Captcha from Uber
     *
     * @param Request $request
     * @return \Psr\Http\Message\StreamInterface
     */
    public function solve(Request $request)
    {
        $site_key = $request->get('key');
        $username = env('CAPTCHA_USERNAME');
        $password = env('CAPTCHA_PASSWORD');


        $data = [
            'googlekey' => $site_key,
            'pageurl' => 'https://auth.uber.com/login/session'
        ];

        $client = new Client([
            'base_uri' => 'http://api.dbcapi.me/api/',
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        $response = $client->post('captcha',[
            'form_params' => [
                'username' => $username,
                'password' => $password,
                'type' => 4,
                'token_params' => json_encode($data)
            ]
        ]);

        $data = $response->getBody();

        $captcha =  json_decode($data, true)['captcha'];

        sleep(60);

        $textImg = $client->get('captcha/'.$captcha, [
            'form_params' => [
                'username' => $username,
                'password' => $password
            ]
        ]);

        return json_decode($textImg->getBody(), true);
    }

}
