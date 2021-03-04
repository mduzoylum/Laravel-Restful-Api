<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TryController extends Controller
{
        public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse(400, [], $validator->errors()->all());
        }
        $credentials = $request->only("name", "password");

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return $this->errorResponse(400, [], "Kullanıcı Adı yada Şifre Hatalı");
        }

        $refresh_token = Str::random(500);

//        $customer = User::find(auth()->id());
//        $customer->token = $token;
//        $customer->refresh_token = $refresh_token;
//        $customer->save();

        return $this->successResponse(200, ["token" => $token, "refresh_token" => $refresh_token], 'Giriş Başarılı');
    }
}
