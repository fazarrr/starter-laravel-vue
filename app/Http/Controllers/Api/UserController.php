<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user;

    public function __construct(Request $request)
    {
        $this->user = new User;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();

        return response()->json([
            'status'    => 'success',
            'data'      => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'          => 'required',
                'email'         => 'required|email',
                'password'      => 'required',
                'role'          => 'required',
                'status'        => 'required|digits:1'
            ],
            [
                'name.required'         => 'Nama wajib diisi',
                'email.required'        => 'Email wajib diisi',
                'email.email'           => 'Format email tidak valid',
                'password.required'     => 'Password wajib diisi',
                'role.required'         => 'Role wajib diisi',
                'status.required'       => 'Active wajib diisi',
                'status.digits'         => 'Active hanya 1 dan 0',
            ]
        );

        $save = $this->user->create([
            'id'        => str::uuid(),
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
            'roles'     => $request->input('role'),
            'is_active' => $request->input('status'),
        ]);

        if (!$save) {
            return response()->json([
                'status'        => 'invalid',
                'message'       => $save->errors(),
            ], 422);
        } else {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data berhasil di simpan',
                'data'      => $save
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ($this->isValidUuid($id)) {
            $data = User::where('id', $id)->first();

            if ($data) {
                return response()->json([
                    'status'    => 'success',
                    'data'      => $data,
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'not found',
                    'message'   => "Data tidak ditemukan",
                ], 404);
            }
        } else {
            return response()->json([
                'status'        => 'error',
                'message'       => "UUID tidak valid",
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $password   = $request->password;

        $request->validate(
            [
                'name'          => 'required',
                'email'         => 'required|email',
                'role'          => 'required',
                'status'        => 'required|digits:1'
            ],
            [
                'name.required'         => 'Nama wajib diisi',
                'email.required'        => 'Email wajib diisi',
                'email.email'           => 'Format email tidak valid',
                'role.required'         => 'Role wajib diisi',
                'status.required'       => 'Active wajib diisi',
                'status.digits'         => 'Active hanya 1 dan 0',
            ]
        );

        if ($password) {
            $update = $this->user->where('id', $id)->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'password'  => Hash::make($password),
                'roles'     => $request->input('role'),
                'is_active' => $request->input('status'),
            ]);
        } else {
            $update = $this->user->where('id', $id)->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'roles'     => $request->input('role'),
                'is_active' => $request->input('status'),
            ]);
        }

        if (!$update) {
            return response()->json([
                'status'        => 'invalid',
                'message'       => "Id user tidak di temukan",
            ], 422);
        } else {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Data berhasil di perbarui',
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function isValidUuid($uuid)
    {
        // Cek format UUID menggunakan regex
        return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid) === 1;
    }
}
