<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{

    public function index()
    {
        $payments = User::all()->toArray();
        return array_reverse($payments);
    }

    public function history($id)
    {
        $payments = Payment::where('user_id',$id)->get()->toArray();
        return array_reverse($payments);
    }
    public function add(Request $request)
    {
        $payment = new User([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        $payment->save();

        return response()->json('Successfully added');
    }

    public function edit($id)
    {
        $payment = User::find($id);
        return response()->json($payment);
    }

    public function update($id, Request $request)
    {
        $payment = User::find($id);
        $payment->update($request->all());

        return response()->json('Successfully updated');
    }

    public function delete($id)
    {
        $payment = User::find($id);
        $payment->delete();

        return response()->json('Successfully deleted');
    }

    public function register(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = 'User register successfully';
        } catch (QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)){
            $success = true;
            $message = 'User login successfully';
        }else {
            $success = false;
            $message = 'Unauthorised';
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = 'Successfully logged out';
        }catch (QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }

    public function get()
    {
        $users = User::all();
        return response()->json($users);
    }
}
