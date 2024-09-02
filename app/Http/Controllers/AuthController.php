<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// Classe de Envio de Email
use App\Mail\SendMailPasswordRecovery;

// Importando a lib de envio de email
use Illuminate\Support\Facades\Mail;

// Form Requests
use App\Http\Requests\Auth\{AuthRegisterRequest, AuthResetPasswordRequest};

// Helpers
use App\Helpers\AuthHelper;

// Resources
use App\Http\Resources\Auth\{LoginResource, RegisterResource, LogoutResource, ResetPasswordResource};

// Models
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {        
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) { 
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken($authUser->name)->plainTextToken; 
            $success['user'] =  $authUser;   
           
            return (new LoginResource(['user' => $success['user'], 'token' => $success['token']]))
                        ->response()
                        ->setStatusCode(Response::HTTP_OK);
        } 
        
        return response()->json(['erro' => 'Email ou Senha inválidos'], Response::HTTP_FORBIDDEN);        
    }

    /**
     * Register a new user.
     *
     * @param  \App\Http\Requests\Auth\AuthRegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(AuthRegisterRequest $request)
    {   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return (new RegisterResource($success))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Log the user out.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::user()->tokens()->where('id', Auth::user()->currentAccessToken()->id)->delete(); 
        return (new LogoutResource("Logout efetuado com sucesso!"))
                    ->response()
                    ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Reset the user's password.
     *
     * @param  \App\Http\Requests\Auth\AuthResetPasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(AuthResetPasswordRequest $request)
    {
        $email = trim($request->email);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'Esse email não está cadastrado na base de dados!'], Response::HTTP_NOT_FOUND);
        }
      
        $randomPassword = AuthHelper::generateRandomPassword();
        $newPassword['password'] = password_hash($randomPassword, PASSWORD_DEFAULT);
        $body = AuthHelper::createPasswordRecoveryEmailBody($user->name, $email, $randomPassword);     

        // Salvando o novo email
        $user->update(['password' => $newPassword['password']]);

        // Fazendo o envio de email com a classe de email
        Mail::to($email)->send(new SendMailPasswordRecovery([
            'assunto' => 'Redefinição de Senha',
            'titulo' => 'Prooceano App - Redefinição de Senha',
            'corpo' => $body,
        ]));

        return (new ResetPasswordResource('senha redefinida com sucesso'))
                    ->response()
                    ->setStatusCode(Response::HTTP_CREATED);
    }
}
