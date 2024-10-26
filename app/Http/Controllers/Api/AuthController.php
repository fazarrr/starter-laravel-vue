<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\{
    User,
};
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    protected $tokens;

    public function login(Request $request)
    {
        $validator = $request->validate(
            [
                'email'     => 'required',
                'password'  => 'required'
            ],
            [
                'email.required'        => 'Email wajib diisi',
                'password.required'     => 'Password wajib diisi'
            ]
        );

        if (!$validator) {
            return response()->json($validator, 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        if ($user->is_active !== 1) {
            return response()->json([
                'status'    => 'error',
                'message'   => "Akun anda non aktif, harap menghubungi Administrator aplikasi",
            ], 401);
        }

        return response()->json([
            'status'    => 'success',
            'token'   => $user->createToken('access-login')->plainTextToken,
        ], 200);
    }

    public function logout(Request $request)
    {
        $revoke = PersonalAccessToken::where('tokenable_id', auth()->id())->delete();

        if ($revoke) {
            return response()->json([
                'status'    => 'success',
                'token'     => 'Logout berhasil',
            ], 200);
        } else {
            return response()->json([
                'status'    => 'gagal',
                'token'     => 'Logout gagal',
            ], 500);
        }
    }

    // public function register()
    // {
    //     $data = ['name' => "Marc BOKO", "password" => "123456789", "email" => "marcboko.uriel@gmail.com"];
    //     $user = User::create($data);
    //     $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
    //     $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

    //     return [
    //         'token' => $accessToken->plainTextToken,
    //         'refresh_token' => $refreshToken->plainTextToken,
    //     ];
    // }

    // public function refreshToken(Request $request)
    // {
    //     $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
    //     return response(['message' => "Token généré", 'token' => $accessToken->plainTextToken]);
    // }
}
