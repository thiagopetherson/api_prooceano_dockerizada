<?php

namespace App\Helpers;

class AuthHelper
{

    //Método para gerar uma senha aleatória
    public static function generateRandomPassword()
    {                    
      $rand = strval(rand(100000,99999999));
      return $rand;
    }  

    //Método para montar o corpo do email de recureção de senha
    public static function createPasswordRecoveryEmailBody($name, $email, $password)
    {
      $body = "<html>";
      $body .= '<body style="font-family:calibri; font-size:16px; text-align:justify;">';
      $body .= '<div style="background-color: rgba(0, 51, 127, 1);border:1px solid gray; color:rgb(55,55,55); padding: 5px 14px 5px 14px; font-size:16px;">';
      $body .= '<h2 style="color:white; font-weight: bold; margin-top: -3px"> Notificação de Email da Plataforma da Prooceano</h2>';
      $body .= '<h4 style="color:white; font-weight: bold; margin-top: -10px; margin-bottom: -3px"> Você fez a solicitação de redefinição de senha. Segue abaixo suas credenciais junto com sua nova senha:</h4>';
      $body .= '</div>';
      $body .= '<div style="background-color:rgb(230,230,230); color:rgb(55,55,55); padding:2%; font-family:verdana; font-size:16px; word-wrap: break-word; white-space: pre-wrap; white-space: -moz-pre-wrap;">';
      $body .= '<span>Nome: <b>'.$name.'</b></span><br>';
      $body .= '<span>Email: <b>'.$email.'</b></span><br>';
      $body .= '<span>Password: <b>'.$password.'</b></span>';
      $body .= '<p><b>OBS: </b>Não responda esse email</p>'; 
      $body .= '</div>';       
      $body .= '</body>';
      $body .= '</html>';

      return $body;

    }

}