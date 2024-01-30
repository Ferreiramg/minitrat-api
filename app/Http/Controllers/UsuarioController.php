<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{


    public function index(Request $request, User $user)
    {
        $token = $request->route()->parameter('token');

        return view('auth.index', [
            'users' => $user->get()->map(function ($user) {

                $user->token = Password::broker('users')->createToken($user);

                return $user;
            }),
            'token' => $token
        ]);
    }

    public function store(Request $request, User $user)
    {

        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:4'
            ]);

            $user->name = trim($request->name);
            $user->email = trim($request->email);
            $user->password = Hash::make($request->password);

            $user->save();

            return response()->json($user);
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->errors()], 422);
        }
    }

    public function restPasswordMail(Request $request)
    {
        try {
            $this->validate($request, ['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['status' => __($status)], 200)
                : response()->json(['email' => __($status)], 404);
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->errors()], 422);
        } catch (Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    
    public function restPassword(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required|email',
                'password_confirmation' => 'required',
                'password' => 'required|min:4|confirmed',
                'token' => 'required'
            ]);

            $status = Password::reset(
                $request->only(['email', 'password', 'password_confirmation', 'token']),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->save();
                }
            );

            return $status === Password::PASSWORD_RESET
                ? response()->json(['status' => __($status)], 200)
                : response()->json(['error' => ['password' => [__($status)]]], 422);
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->errors()], 422);
        } catch (Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
