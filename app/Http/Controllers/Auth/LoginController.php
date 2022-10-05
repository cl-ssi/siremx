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

        if($resp) {
            return response()->json([
                'authUser' => Auth::user(),
                'code'     => 200
            ]);
        }
        else {
            return response()->json([
                'code'     => 401
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

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

			$u = User::where('run',$user_cu->RolUnico->numero)->first();
			
			if($u) {
				Auth::login($u, true);
				$resp = auth()->id();
				if($resp) {
					return response()->json([
						'authUser' => Auth::user(),
						'code'     => 200
						
					]);
				}
				else {
					return response()->json([
						'code'     => 401
					]);
				}
			}
			else {
				return response()->json([
					'code'     => 401
				]);
			}
            
        }
    }
}
