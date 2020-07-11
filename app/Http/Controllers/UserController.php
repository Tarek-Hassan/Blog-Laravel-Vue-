<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::with('orders')->get());
        //
    }
    public function login(Request $request){
        if(Auth::attempt($request->only(['email','password']))){
            $status=200;
            $response=[
                'user'=>Auth::user(),
                'token'=>Auth::user()->createToken('store')->accessToken,
            ];

        }
        else{
            $status=401;
            $response=['error'=>'unauthorized'];
        }
        return response()->json($response,$status);
    }

    public function register(Request $request){

    $validator= Validator::make($request->all(),[
        'name'=>'required|max:50',
        'email'=>'required|email',
        'password'=>'required|min:6',
        'c_password'=>'required|same:password',
    ]);
    if($validator->fails()){
        return response()->json(['error'=>$validator->errors()],401);
    }
    $request['password']=Hash::make($request->password);
    $user=User::created($request->all());
    return response()->json([
        'user'=>$user,
        'token'=>$user->createToken('store')->accessToken]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        // return response()->json(User::findOrFail($id));
        return response()->json($user);
    }
    public function showOrders(User $user)
    {
        //
        // return response()->json(User::findOrFail($id));
        return response()->json($user->orders()->with('products')->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
