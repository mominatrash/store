<?php

namespace App\Http\Controllers;

use App\Mail\ExampleMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request){



        $usere = User::where('email',$request->email)->first();
        $userp = User::where('phone',$request->phone)->first();
        $randomCode = rand(1000,9999);

        if($request->mohammed == 1){
            $m = 'true';
        }

        return $m;


        if(isset($m)){
            return 'true';
        }else{
            return 'false';
        }


        if($usere){

            return '1';

        }elseif($userp){

            return '2';
        }else{
            return '0';
        }



    }

    public function send()
    {
        $random = rand(1111,9999);


       // $recipient = 'gonegamer11@gmail.com';
          $recipient = 'moamennew@gmail.com';
       // $recipient = 'obaatrash1@gmail.com';


        Mail::to($recipient)->send(new ExampleMail($random));
    }
}


