<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ExampleMail;
use illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function login(Request $request)
    {

        if(isset($request->phone)){

            if(isset($request->email)){
                $usere = User::where('email',$request->email)->first();
                $usere->phone=$request->phone;
                // $ran=rand(1000, 9999);
                // $usere->phone_code=$ran;
                 $usere->save();
                //code sent
                return response()->json([
                    'code'=>200,
                    'message'=>'Phone and Email',
                ]);

            }
            $userp = User::where('phone',$request->phone)->first();
            if($userp){
            // $ran=rand(1000, 9999);
            // $usere->phone_code=$ran;
            // $usere->save();
            //code sent
            return response()->json([
                'code'=>200,
                'message'=>'Phone Login',
            ]);
        }else{
            $user=new User();
            $user->phone =  $request->phone;
            // $user->name = $request-> name;
            $user->save();
            //send code
            return response()->json([
                'code'=>200,
                'message'=>'Phone Register',
            ]);
        }
        }elseif(isset($request->email)){
            $usere = User::where('email',$request->email)->first();

            if($usere)
            {
            $ran=rand(1000, 9999);
            $usere->email_code=$ran;
            $usere->save();

            $s=$request->email;
            Mail::to ($s)->send(new ExampleMail($ran));
            return response()->json([
                'code'=>200,
                'message'=>'Email Login',
            ]);

            }else{
                $random=rand(1000, 9999);
                $user=new User();
                $user->email =  $request->email;
                $user->email_code=$random;
                // $user->name = $request-> name;
                $user->save();
                $s=$request->email;
            Mail::to ($s)->send(new ExampleMail($random));
            return response()->json([
                'code'=>200,
                'message'=>'Email Register',
            ]);
            }
        }
    }

    public function verify(Request $request){

        if(isset($request->phone_code)){

            $user = User::where('phone',$request->phone)->first();

            if($user->phone_code == $request->phone_code){

                User::where('phone_code', $request->phone_code)->update(['phone_code' => null]);

                $token ['token'] = $user->createToken('accessToken')->accessToken;

                return response()->json([
                    'message' => 'phone verified successfully',
                    'code' => 200,
                    'data' => $user

                ]);



        }else{

                return false;
        }


        }elseif(isset($request->email_code)){

        $user = User::where('email',$request->email)->first();

        if($user->email_code == $request->email_code){
            $expired = User::where('email_code', $request->email_code)->first();
            $expired->expired_email_code = $request->email_code;
            $expired->save();
            User::where('email_code', $request->email_code)->update(['email_code' => null]);

            // $randomCode = rand(1000,9999);
            // $recipient = $request->email;
            // Mail::to($recipient)->send(new ExampleMail($randomCode));

            return response()->json([
                'message' => 'email verified successfully',
                'code' => 200,

            ]);

        }elseif($user->expired_email_code == $request->email_code){


            return response()->json([
                'message' => 'code is expired',
                'code' => 200,
            ]);
        }


        else{

            return response()->json([
                'message' => 'incorrect code',
                'code' => 200,
            ]);
        }

     }
    }
}





    //     if(isset($m)){
    //         return 'true';
    //     }else{
    //         return 'false';
    //     }

//     public function send()
//     {
//         $random = rand(1111,9999);


//        // $recipient = 'gonegamer11@gmail.com';
//          $recipient = 'moamennew@gmail.com';
//        // $recipient = 'obaatrash1@gmail.com';


//         Mail::to($recipient)->send(new ExampleMail($random));
//     }
// }


