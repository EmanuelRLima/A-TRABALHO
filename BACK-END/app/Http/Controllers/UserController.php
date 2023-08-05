<?php

namespace App\Http\Controllers;

use App\Exceptions\AppBaseException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public const DEFAULT_DISK = 'public';

    public function register(Request $request)
    {
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_name' => $request->user_name,
            'user_category_id' => $request->user_category_id,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'sucesso' => true,
            'data' => $user,
        ]);

    }

    public function login(Request $request)
    {
        // To-do: Validar request
        $credentials = $request->only('email','password');

        if(!auth()->attempt($credentials)) abort(401, 'Erro');

        // Desconecta o usuário de todas as sessões anteriores
        Auth::logoutOtherDevices($request->password);
        $token = auth()->user()->createToken('auth_token');
        return response()->json([
            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete(); 
        return response()->json([
            'data' => [
                'logout' => true
            ]
        ], 204);
    }

    public function index(Request $request)
    {
        $users = User::findWithFilters($request->all());
        return response()->json([
            'sucesso' => true,
            'data' => $users,
        ]);
    }
    
    public function edit(Request $request){
        $user = Auth::user();
        $data = $request->only(['name', 'user_name', 'email', 'user_category_id']);
        $now_password = $request->now_password;
            // Verifica se a senha antiga fornecida corresponde à senha atual do usuário
            if (password_verify($now_password, $user->password)) {
                $password = bcrypt($now_password);
                $data['password'] = $password;
            } else {
                return response()->json([
                    'msg' => 'Senha incorreta'
                ], 400);
            }
        
        $user->fill($data);
        $user->save();
        return response()->json([
            'msg' => 'Dados alterados com sucesso'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    function updateUser(Request $request, $id){
        try{
            \DB::transaction(function() use($request){
                User::findOrFail($id)
                    ->update($request->all());
            });
        } catch(\Exception $e){
            return response()->json([$e], 500);
        }
        return response()->json(['Dados de perfil alterados com sucesso'], 200);
    }
}
