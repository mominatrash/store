<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Code;
use App\Models\Game;
use App\Models\User;
use App\Mail\CodeMail;
use App\Mail\ExampleMail;
use App\Models\Favourite;
use App\Models\Game1;
use App\Models\Order;
use illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
                $usere ['token'] = $usere->createToken('accessToken')->accessToken;

                return response()->json([
                    'code'=>200,
                    'message'=>'Phone and Email',
                    'data' => $usere,
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

            $usere ['token'] = $usere->createToken('accessToken')->accessToken;

            $s=$request->email;
            Mail::to ($s)->send(new ExampleMail($ran));
            return response()->json([
                'code'=>200,
                'message'=>'Email Login',
                'data' => $usere
            ]);

            }else{
                $random=rand(1000, 9999);
                $user=new User();
                $user->email =  $request->email;
                $user->email_code=$random;
                // $user->name = $request-> name;
                $user->save();

                $user ['token'] = $user->createToken('accessToken')->accessToken;
                $s=$request->email;
            Mail::to ($s)->send(new ExampleMail($random));
            return response()->json([
                'code'=>200,
                'message'=>'Email Register',
                'data' => $user
            ]);
            }
        }
    }

    public function verify(Request $request){

        if(isset($request->phone_code)){

            $user = User::where('phone',$request->phone)->first();

            if($user->phone_code == $request->phone_code){

                User::where('phone_code', $request->phone_code)->update(['phone_code' => null]);

                $user ['token'] = $user->createToken('accessToken')->accessToken;

                return response()->json([
                    'message' => 'phone verified successfully',
                    'code' => 200,
                    'data' => $user,


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

    public function add_fav(Request $request){


        $isfav = Favourite::where('user_id', Auth::guard('api')->user()->id)->where('game_id', $request->game_id)->first();
        //$game = Game::where('user_id',Auth::guard('api')->user()->id)->where('game_id', $request->game_id)->first(['name']);
        if($isfav){
            $isfav->delete();

            return response([
                'status' => true,
                'message' => 'Game ' . $request->game_id . ' has been removed from favourites',
            ]);

         } else{

        // if($request->game_id == Favourite::where('user_id', Auth::guard('api')->user()->id));

        $fv = new Favourite();
        $fv->user_id = Auth::guard('api')->user()->id;
        $fv->game_id = $request->game_id;
        $fv->save();

        return response()->json([
            'message' => 'game added to favourites successfully',
            'code' => 200,
            'game' => $fv,
        ]);
    }



    }

    public function favouriteGames(){

        $fg = Favourite::where('user_id', Auth::guard('api')->user()->id)->get();

        $favs = [];
        foreach ($fg as $item) {
            $fav = Game::where('id', $item->game_id)->first(['name']);
            $favs[] = $fav;
        }


        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'game' => $favs,
        ]);

    }

    public function addToCart(Request $request){


        $iscart = Cart::where('user_id', Auth::guard('api')->user()->id)->where('game_id', $request->game_id)->first();

        //$game = Game::where('user_id',Auth::guard('api')->user()->id)->where('game_id', $request->game_id)->first(['name']);
        if($iscart){
            $iscart->delete();

            return response([
                'status' => true,
                'message' => 'Game ' . $request->game_id . ' has been removed from cart',
            ]);

         } else{

        // if($request->game_id == Favourite::where('user_id', Auth::guard('api')->user()->id));

        $cart = new Cart();
        $cart->user_id = Auth::guard('api')->user()->id;
        $cart->game_id = $request->game_id;
        $cart->package_id = $request->package_id;
        $cart->quantity = $request->quantity;
        $cp = Game1::where('id', $request->game_id)->value('price');
        $cart->price = $cp;
        $cart->save();

        return response()->json([
            'message' => 'Game ' . $request->game_id .'of package id '.$request->package_id. ' added to cart successfully',
            'code' => 200,
        ]);
    }



    }

    public function cartGames(){


        $c = Cart::where('user_id', Auth::guard('api')->user()->id)->get()->makeHidden(['created_at','updated_at']);

        $total = 0;

        foreach ($c as $item) {
            $total += $item->quantity * $item->price;
        }


        // $carts = [];
        // foreach ($c as $item) {
        //     $cart = Game1::where('id', $item->game_id)->first();
        //     $carts[] = $cart;
        // }


        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'game' => $c,
            'total price' => $total
        ]);

    }

    public function pfp(Request $request){


        if (!$request->hasFile('file')) {
            return response()->json([
                'message' => 'No file uploaded',
                'code' => 400
            ]);
        }

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->store('apiDocs');
        $pfp = User::where('id', Auth::guard('api')->user()->id)->first();
        $pfp->pfp = $path;
        $pfp->save();

        return response()->json([
            'message' => 'data fetched successfully',
            'code' => 200,
            'Profile picture' => $pfp,$filename
        ]);
    }


    public function purchase(Request $request)
    {
        $quantity = $request->quantity;
        $codes = '';
        // if(isset($request->quantity))
        for ($i = 0; $i < $quantity; $i++) {
            $code = Code::where('sold', 0)->where('game_id', $request->game_id)->where('package_id', $request->package_id)->first();
            $code->sold = 1;
            $code->user_id = Auth::guard('api')->user()->id;
            $code->save();

            $codes .= $code->code .' || ';
        // }else{
        //     $code = Code::where('sold', 0)->where('game_id', $request->game_id)->where('package_id', $request->package_id)->first();
        //     $code->sold = 1;
        //     $code->user_id = Auth::guard('api')->user()->id;
        //     $code->save();
        // }

        $email = Auth::guard('api')->user()->email;
        $codes = rtrim($codes, ' || '); // Remove the last separator
        if(isset($request->quantity)){
        Mail::to($email)->send(new CodeMail($codes));
        // }else{
        // Mail::to($email)->send(new CodeMail($code->code));
        }
    }

        return response()->json([
            'message' => 'Codes sent to ' . $email,
            'code' => 200,
        ]);
    }

    public function total_price(){

    $cart = Cart::where('user_id', Auth::guard('api')->user()->id)->get();
    $total = 0;

    foreach ($cart as $item) {
        $total += $item->quantity * $item->price;
    }

    return response()->json([
        'message' => 'data fetched successfully',
        'code' => 200,
        'total_price' => $total
    ]);

    }

    public function buy_cart()
    {
        $cart = Cart::where('user_id', Auth::guard('api')->user()->id)->get();


        foreach ($cart as $c) {
            for ($i = 0; $i < $c->quantity; $i++) {
                $code = Code::where('game_id', $c->game_id)
                    ->where('package_id', $c->package_id)
                    ->where('sold', 0)
                    ->first();

                if ($code) {
                    $code->sold = 1;
                    $code->user_id = Auth::guard('api')->user()->id;
                    $code->save();
                    Mail::to(Auth::guard('api')->user()->email)->send(new CodeMail($code->code));


                }
            }

            $c->delete();
        }



        return response()->json([
            'message' => 'Order sent successfully',
            'code' => 200,
        ]);
    }






    public function my_order(Request $request){
        $purchase_id = Code::where('user_id', Auth::guard('api')->user()->id )->get();

        return response()->json([
            'message' => 'Your order is ',
            'code' => 200,
            'order' => $purchase_id
        ]);
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


