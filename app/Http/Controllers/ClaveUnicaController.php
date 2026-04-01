<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\User;
use Illuminate\Support\Facades\Log;

class ClaveUnicaController extends Controller
{
    /**
    * Login Clave única
    */
    public function autenticar(Request $request){
        /* Primer paso, redireccionar al login de clave única */
        $url_base       = "https://accounts.claveunica.gob.cl/openid/authorize/";
        $client_id      = env("CLAVEUNICA_CLIENT_ID");
        $redirect_uri   = urlencode(env('APP_URL')."/claveunica/callback");

        $state          = csrf_token();
        $scope          = 'openid run name';

        $params         = '?client_id='.$client_id.
                        '&redirect_uri='.$redirect_uri.
                        '&scope='.$scope.
                        '&response_type=code'.
                        '&state='.$state;

        return redirect()->to($url_base.$params)->send();
    }

    public function callback(Request $request) {
        /* Segundo paso, el usuario ya se autentificó correctamente en CU y retornó a nuestro sistema */

        /* Nos aseguramos que vengan los parámetros desde CU */
        // if ($request->missing(['code','name'])) {
        // 	return redirect()->route('welcome');
        // }

        /* Recepcionamos los siguientes parametros desde CU */
        $code   = $request->input('code');
        $state  = $request->input('state'); 

        $token_response = $this->getAccessToken($code, $state);

        if (!$token_response || !isset($token_response->access_token)) {
            return redirect('/auth/login?error=cu_auth_failed');
        }
        $access_token = $token_response->access_token;

        // Obtener datos del usuario desde Clave Única
        $user_info = $this->getUserInfo($access_token);
        Log::error($user_info);
        if (!$user_info || !isset($user_info->run)) {
            return redirect('/auth/login?error=cu_no_user_data');
        }

        // Buscar usuario en tu BD por RUN
        $user = User::where('run', $this->formatRun($user_info->run))->first();

        if (!$user) {
            return redirect('/auth/login?error=user_not_found');
        }

        // Verificar si el usuario está activo
        if (!$user->active) {
            return redirect('/auth/login?error=user_inactive');
        }

        // CREAR SESIÓN TEMPORAL con el token de acceso interno
        $internal_token = bin2hex(random_bytes(32));

        Cache::put('cu_login_' . $internal_token, [
            'user_id' => $user->id,
            'user_info' => $user_info,
            'expires_at' => now()->addMinutes(5)
        ], 300);        


        // Redirigir a Vue con el token interno (no el de Clave Única)
        return redirect('/auth/logincu/' . $internal_token);
    }


    private function getAccessToken($code, $state)
    {
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

        if ($response->failed()) {
            Log::error('Clave Única token error: ' . $response->body());
            return null;
        }

        return json_decode($response->body());
    }

    private function getUserInfo($access_token)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->get('https://accounts.claveunica.gob.cl/openid/userinfo/');

        if ($response->failed()) {
            Log::error('Clave Única userinfo error: ' . $response->body());
            return null;
        }

        return json_decode($response->body());
    }

    private function formatRun($run)
    {
        // Formatear RUN según tu BD (con o sin puntos, con guión)
        return $run; // Ajusta según tu formato
    }    

    public function logout() {
        /* Nos iremos al cerrar sesión en clave única y luego volvermos a nuestro sistema */
        if(env('APP_ENV') == 'local')
        {
            /* Si es ambiente de desarrollo cerramos sólo localmente */
            //dd('llegue');
            return redirect()->route('logout');
        }
        else
        {
            /** Cerrar sesión clave única */
            /* Url para cerrar sesión en clave única */
            $url_logout     = "https://accounts.claveunica.gob.cl/api/v1/accounts/app/logout?redirect=";
            /* Url para luego cerrar sesión en nuestro sistema */
            $url_redirect   = env('APP_URL')."/authenticate/logout";
            $url            = $url_logout.urlencode($url_redirect);
            return redirect($url);
        }
    }
}
