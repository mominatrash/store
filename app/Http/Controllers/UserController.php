<?php

namespace App\Http\Controllers;

use App\Mail\ExampleMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request){

        $usere = User::where('email',$request->email)->first();
        $userp = User::where('phone',$request->phone)->first();
        if($usere){
            

            $randomCode = rand(1000,9999);

            //$user = User::where('email', $request->email)->first();
            $usere->email_code = $randomCode;
            $usere->save();

        }elseif($userp){

            // $randomCode = rand(1000,9999);
            // $usere->phone_code = $randomCode;
            // $usere->save();

        }

        elseif($request->email){

            $reg = new User();

            $reg->email = $request->email;
            $reg->save();

            $recipient = 'moamennew@gmail.com';
            Mail::to($recipient)->send(new ExampleMail());

        }else{

            $reg = new User();

            $reg->phone = $request->phone;
            $reg->save();
        }


    }

    public function send()
    {
        $random = rand(1111,9999);


        $recipient = 'moamennew@gmail.com';
        Mail::to($recipient)->send(new ExampleMail($random));
    }
}


