<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // Return Json Response
        return response()->json([
            'results' => $users
        ], 200);
    }

    public function tambah(UserStoreRequest $request)
    {
        try{
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            return response()->json([
                'Yay' => 'Berhasil Menambahkan User'
            ],200);
        } catch (\Exception $e){
            return response()->json([
                'Error' => 'Ada yang salah!'
            ],500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $users = User::find($id);
            if(!$users){
                return response()->json([
                    'Error' => 'User Tidak Ada.'
                ],404);
            }

                $users->name = $request->name;
                $users->password = $request->password;
                $users->email = $request->email;
            
            
            $users->save();
            
            \Log::info('Data yang diterima:', $request->all());
            return response()->json([
                'Yay' => 'Berhasil edit uaer.'
            ],200);


        } catch (\Exception $e) {
            return response()->json([
                'Error' => 'Ada yang bermasalah.',
                'message' => $e->getMessage(),
            ],400);
        }
    }

    public function show($id)
    {
        $users = User::find($id);
        if(!$users){
            return response()->json([
                'Error' => 'User Tidak Ada.'
            ],404);
        }
        return response()->json([
            'User' =>$users
        ],200);
    }

    public function destroy($id)
    {
        $users = User::find($id);
        if(!$users){
            return response()->json([
                'Error' => 'User Tidak Ada.'
            ],404);
        }

        $users->delete();

        return response()->json([
            'Yay' => 'Berhasil mneghancurkan'
        ],200);
    }
}
