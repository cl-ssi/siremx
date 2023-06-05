<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use App\User;

class LoginController extends Controller
{

    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    public function login(Request $request)
    {

        $email    = $request->email;
        $password = $request->pass;
        $resp     = Auth::attempt(['username' => $email, 'password' => $password, 'state' => 'A']);

        if ($resp) {
            return response()->json([
                'authUser' => Auth::user(),
                'code'     => 200
            ]);
        } else {
            return response()->json([
                'code'     => 401
            ]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        // return redirect()->route('claveunica.logout');

        return response()->json([
            'code'     => 204
        ]);
    }

    public function logincu($access_token = null)
    {
        if ($access_token) {
            /* Paso 3, obtener los datos del usuario en base al $access_token */
            $url_base = "https://accounts.claveunica.gob.cl/openid/userinfo/";
            $response = Http::withToken($access_token)->post($url_base);
            $user_cu = json_decode($response);

            $u = User::where('run', $user_cu->RolUnico->numero)->first();

            if ($u) {
                Auth::login($u, true);
                $resp = auth()->id();
                if ($resp) {
                    return response()->json([
                        'authUser' => Auth::user(),
                        'code'     => 200

                    ]);
                } else {
                    return response()->json([
                        'code'     => 401
                    ]);
                }
            } else {
                /** Cerrar sesión clave única */
                /* Url para cerrar sesión en clave única */
                $url_logout     = "https://accounts.claveunica.gob.cl/api/v1/accounts/app/logout?redirect=";
                /* Url para luego cerrar sesión en nuestro sisetema */
                $url_redirect   = env('APP_URL') . "/claveunica/logout";
                $url            = $url_logout . urlencode($url_redirect);
                session()->flash('danger', 'Esta cuenta no coincide con nuestros registros');
                return redirect($url);
                // return response()->json([
                //     'code'     => 401
                // ]);
            }
        }
    }

    /**
    * Redirect Vue Login
    */
    public function redirectVueLogin($access_token)
    {
        $url = config('app.url').'/siremx/logincu/'.$access_token;
        return redirect($url);
    }
}
