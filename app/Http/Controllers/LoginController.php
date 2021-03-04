<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LoginController extends Controller
{
    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3",
            "password" => "required|min:3"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, [], 'Kullanıcı Adı yada Şifreniz Uygun Değil');
        }

        $credentials = $request->only("name", "password");

        if (!$token = auth()->attempt($credentials)) {
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, [], 'Kullanıcı Adı yada Şifreniz Hatalı');
        }

        $refresh_token = Str::random(256);

        $customer = Customers::find(auth()->id());
        $customer->token = $token;
        $customer->refresh_token = $refresh_token;
        $customer->save();

        return $this->successResponse(200, ["token" => $token, "refresh_token" => $refresh_token], 'Giriş Başarılı');
    }

    public function secret()
    {
        return $this->successResponse(200, [], 'Gizli Alana Hoşgeldin');
    }

    public function refreshToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "refresh_token" => "required|min:256"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, [], $validator->errors()->all());
        }

        $customer = Customers::where("refresh_token", $request->input("refresh_token"))->first();

        if ($customer) {
            $token = auth()->login($customer);
            $customer->token = $token;
            $customer->update();
            return $this->successResponse(200, ["token" => $token, "refresh_token" => $request->input("refresh_token")], 'Giriş Başarılı');
        }

        return $this->errorResponse(403, [], 'Token Hatalı');
    }

    public function logout()
    {
        try {
            auth()->logout();
        } catch (TokenExpiredException $e) {
            return $this->errorResponse(401, [], 'Token Süresi Doldu');
        } catch (TokenInvalidException $e) {
            return $this->errorResponse(401, [], 'Token Geçersiz Kılındı');
        } catch (JWTException $e) {
            return $this->errorResponse(401, [], 'Token Hatası');
        }
        return $this->successResponse(200, [], 'Logout Başarılı');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                "name" => "required|min:3|unique:customers,name",
                "email" => "required|email|unique:customers,email",
                "password" => "required|confirmed|min:3"
            ]);

        if ($validator->fails()) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, [], $validator->errors()->all());
        }

        $customer = new Customers();
        $customer->name = $request->input("name");
        $customer->email = $request->input("email");
        $customer->password = bcrypt($request->input("name"));
        $customer->save();

        $token = auth()->login($customer);
        $refresh_token = Str::random(256);


        $customer->token = $token;
        $customer->refresh_token = $refresh_token;
        $customer->update();

        return $this->successResponse(200, ["token" => $token, "refresh_token" => $refresh_token], 'Kayıt Başarılı');

    }
}
