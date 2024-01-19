<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Resources\JwtResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenController extends Controller{

    public function login(LoginRequest $loginRequest){
        $userEmailLogin = User::where([
            'email' => $loginRequest->email,
        ])->first();
        // dd($userEmailLogin,$loginRequest->email);
        if(!$userEmailLogin){
            return response()->json(['message' => 'Please check your login information Email!'],404);
        }

        $userPasswordLogin = $userEmailLogin->password;
        $salt = $userEmailLogin->salt;

        $password =  $this->generateHashedPassword($userPasswordLogin, $salt);

        if (!Hash::check($loginRequest->password, $userPasswordLogin)) {
            return response()->json(['message'=>'Please check your login information Password!'],401);
        }

        $accessToken = JWTAuth::fromUser($userEmailLogin);
        return $this->createNewToken($accessToken);
        
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();
            // dd($validatedData);

            $user = User::create([
                'email' => $validatedData['email'], 
                'password' => Hash::make($validatedData['password']),
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
            ]);

            return response()->json([
                'message' => 'Successfully created user!',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // public function logout(){

    // }

    public function index(){
        return "Checking ...";
    }

    private function generateDynamicValue(){
        return uniqid(mt_rand(), true);
    }
    private function hashString($input){
        return hash('sha512', $input);
    }

    protected function generateHashedPassword($userInputPassword, $salt) {
        // Generate a dynamic value
        $dynamicValue = $this->generateDynamicValue();
      
        // Concatenate the dynamic value, plain text password, and salt
        $combinedString = $dynamicValue . $userInputPassword . $salt;

        // Hash the combined string using SHA-512
        $hashedPassword = $this->hashString($combinedString);
        // dd($dynamicValue,$combinedString,$hashedPassword);
        return $hashedPassword;
    }

    protected function createNewToken($token)
    {
        $jwt = JwtResource::make($token);
        return response()->json($jwt, 200);
    }

}