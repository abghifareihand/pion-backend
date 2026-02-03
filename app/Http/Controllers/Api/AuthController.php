<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username'   => 'required|string',
            'password'   => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();


        // ❌ Kalau user tidak ditemukan
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password salah',
            ], 401);
        }

        // 🔐 Cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password salah',
            ], 401);
        }


        // ✅ Cegah login kalau role = admin
        if ($user->role === 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Akun admin hanya bisa login melalui dashboard web'
            ], 403);
        }

        // ✅ Buat token login
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'data'    => [
                'user'  => $user,
                'token' => $token,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        // ✅ Hapus token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    public function profile(Request $request)
    {
        // ✅ Ambil data user berdasarkan token
        $user = $request->user();

        return response()->json([
            'status' => true,
            'message' => 'Data profil berhasil diambil',
            'data' => $user
        ]);
    }

    public function updateFcmToken(Request $request)
    {
        // ✅ Update FCM token user setelah login dari Aplikasi
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $user = $request->user();
        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'FCM token berhasil diperbarui',
            'fcm_token' => $user->fcm_token,
        ]);
    }
}
