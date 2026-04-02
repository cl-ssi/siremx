<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Auth\LoginController;

class ClaveUnicaController extends Controller
{
    public function autenticar(Request $request)
    {
        $url_base = "https://accounts.claveunica.gob.cl/openid/authorize/";
        $client_id = env("CLAVEUNICA_CLIENT_ID");
        $redirect_uri = urlencode(env('APP_URL') . "/claveunica/callback");
        $state = csrf_token();
        $scope = 'openid run name';
        
        $params = '?client_id=' . $client_id .
                  '&redirect_uri=' . $redirect_uri .
                  '&scope=' . $scope .
                  '&response_type=code' .
                  '&state=' . $state;

        return redirect()->to($url_base . $params)->send();
    }

    public function callback(Request $request)
    {
        $code = $request->input('code');
        $state = $request->input('state');

        $url_base = "https://accounts.claveunica.gob.cl/openid/token/";
        $client_id = env("CLAVEUNICA_CLIENT_ID");
        $client_secret = env("CLAVEUNICA_SECRET_ID");
        $redirect_uri = urlencode(env('APP_URL') . "/claveunica/callback");

        $response = Http::asForm()->post($url_base, [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'state' => $state,
        ]);

        $access_token = json_decode($response->body())->access_token ?? null;

        if (!$access_token) {
            return redirect('/auth/login?error=cu_failed');
        }

        return redirect()->action([LoginController::class, 'redirectVueLogin'], ['access_token' => $access_token]);
    }

    public function logout()
    {
        if (env('APP_ENV') == 'local') {
            return redirect()->route('logout');
        }

        $url_logout = "https://accounts.claveunica.gob.cl/api/v1/accounts/app/logout?redirect=";
        $url_redirect = env('APP_URL') . "/authenticate/logout";
        $url = $url_logout . urlencode($url_redirect);
        
        return redirect($url);
    }
}