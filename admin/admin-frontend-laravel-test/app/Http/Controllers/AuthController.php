<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request) {
        
        $request->validated($request->all());

        if(Auth::attempt($request->only(['email', 'password']))){
            $user = User::where('email', $request->email)->first();

            $users = new LoginResource($user);

            $token = $user->createToken('API Token of '. $user->email);

            return $this->success([
                'user' => $users,
                'token' => $token->plainTextToken,
                'expires_at' => $token->accessToken->expires_at
            ]);
        }

        if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->error('', 'Credentials do not match', 401);
        }
        
    }

    public function register(StoreUserRequest $request) {

        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->success([
            'data' => $user,
            'token' =>$user->createToken('API Token of '. $user->name)->plainTextToken
        ]);
    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have successfully logged out and your token has been deleted'
        ]);
    }

}
