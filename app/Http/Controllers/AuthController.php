<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Classe de Envio de Email
use App\Mail\SendMailPasswordRecovery;
 // Importando a lib de envio de email
use Illuminate\Support\Facades\Mail;
// Chamando os Form Requests (Para validação)
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Requests\Auth\AuthResetPasswordRequest;
// Chamando o helper
use App\Helpers\AuthHelper;

class AuthController extends Controller
{
    public function login(Request $request)
    {        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken($authUser->name)->plainTextToken; 
            $success['user'] =  $authUser;   
           
            return response()->json(['user' => $success['user'],  'token' => $success['token']], 200);
        } 
        
        return response()->json(['erro' => 'Email ou Senha inválidos'], 403);        
    }

    public function register(AuthRegisterRequest $request)
    {   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return response()->json($success, 200); 
    }

    public function logout () {
        Auth::user()->tokens()->where('id', Auth::user()->currentAccessToken()->id)->delete(); 
        return response()->json(['msg' => "Logout efetuado com sucesso!"], 200);
    }

    public function resetPassword (AuthResetPasswordRequest $request) {

        $email = trim($request->email);
        $user = User::where('email',$email)->first();

        if(!$user){
            return response()->json(['error' => 'Esse email não está cadastrado na base de dados!'], 404);
        }
      
        $randomPassword = AuthHelper::generateRandomPassword();
       
        $newPassword['password'] = password_hash($randomPassword , PASSWORD_DEFAULT);
        
        $body = AuthHelper::createPasswordRecoveryEmailBody($user->name, $email, $randomPassword);     

        // Salvando o novo email
        $user->update(['password' => $newPassword['password']]);

        // Fazendo o envio de email com a classe de email
        Mail::to($email)->send(new SendMailPasswordRecovery(array(
            'assunto' => 'Redefinição de Senha',
            'titulo' => 'Prooceano App - Redefinição de Senha',
            'corpo' => $body
        ))); 

        return response()->json(['sucesso' => 'senha redefinida com sucesso'], 201);
    }
}
