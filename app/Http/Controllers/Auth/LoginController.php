<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\User;

class LoginController extends Controller
{
    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->pass;

        $resp = Auth::attempt([
            'username' => $email,
            'password' => $password,
            'state' => 'A'
        ]);

        if ($resp) {
            $request->session()->regenerate();
            return response()->json([
                'authUser' => Auth::user(),
                'code' => 200
            ]);
        }

        return response()->json(['code' => 401], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['code' => 204]);
    }

    public function logincu($access_token = null)
    {
        Log::info('logincu llamado', ['token' => substr($access_token ?? '', 0, 20)]);

        if (!$access_token) {
            return response()->json(['code' => 401, 'message' => 'No token'], 401);
        }

        try {
            $url_base = "https://accounts.claveunica.gob.cl/openid/userinfo/";
            $response = Http::withToken($access_token)->get($url_base);
            Log::info('CU Response', ['body' => $response->body(), 'status' => $response->status()]);

            if ($response->failed()) {
                Log::error('CU userinfo failed', ['status' => $response->status()]);
                return response()->json(['code' => 401, 'message' => 'Error al validar con Clave Única'], 401);
            }

            $user_cu = $response->json();
            $run = $user_cu['RolUnico']['numero'] ?? null;

            if (!$run) {
                Log::error('CU sin RUN', $user_cu);
                return response()->json(['code' => 401, 'message' => 'Datos incompletos de Clave Única'], 401);
            }

            $run = $user_cu['RolUnico']['numero'] ?? null;
            // Intentar buscar sin formato y con formato
            $u = User::where('run', $run)->first();
            // $u = User::where('run', $run)->first();


            if (!$u) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Usuario no existe en BD',
                    'run_buscado' => $run,
                    'run_formateado' => intval($run) // Por si viene con formato diferente
                ], 401);
            }

            /*
            if (!$u) {
                Log::warning('Usuario no encontrado', ['run' => $run]);
                return response()->json(['code' => 401, 'message' => 'Usuario no registrado en el sistema'], 401);
            }
            */

            Auth::login($u, true);
            request()->session()->regenerate();

            Log::info('Login CU exitoso', ['user_id' => $u->id]);

            return response()->json([
                'authUser' => Auth::user(),
                'code' => 200
            ]);
        } catch (\Exception $e) {
            Log::error('Excepción en logincu', ['error' => $e->getMessage()]);
            return response()->json(['code' => 500, 'message' => 'Error interno'], 500);
        }
    }

    public function redirectVueLogin($access_token)
    {
        return redirect('/auth/logincu/' . $access_token);
    }
}
