<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{

    public static function UserLogin($validation = null, $message = null){
        $validation = [
            'email'                 => 'required|max:50',
            'password'              => 'required|max:16|min:6',

        ];


        $message = [
            'email.email'       =>  'Please enter a valid email address.',
            'email.exists'      =>  'Please enter registered email address.',
            'email.required'    =>  'Please enter email address.',
            'password.required' =>  'Please enter password.',
            'password.min'      =>  'Please enter valid email or password.',
            'password.max'      =>  'Please enter valid email or password.',
        ];

        return $data = ['validation' => $validation, 'message' => $message];
    }


    public static function userRegister($validation = null, $message = null){
        $validation = [
            'name'                  => 'required|max:50',
            'email'                 => 'required|unique:users|max:50',
            'password'              => 'required|max:16|min:6',

        ];


        $message = [
            'email.email'       =>  'Please enter a valid email address.',
            'email.exists'      =>  'Please enter registered email address.',
            'email.required'    =>  'Please enter email address.',
            'password.required' =>  'Please enter password.',
            'password.min'      =>  'Please enter valid email or password.',
            'password.max'      =>  'Please enter valid email or password.',
        ];

        return $data = ['validation' => $validation, 'message' => $message];

    }
}
