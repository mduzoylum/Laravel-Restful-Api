<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function getCities() // camelcase => getCitiesDistrict, snakecase => get_cities_district
    {
        $cities = Cities::all();
        return $this->successResponse(Response::HTTP_OK, $cities, 'Şehirler Başarılı Bir Şekilde Getirildi'); // Response::HTTP_OK => 200
    }

    public function getCityById(Cities $cities)
    {
        return $this->successResponse(Response::HTTP_OK, $cities, 'Şehir Getirildi'); // Response::HTTP_OK => 200
    }

    public function saveCity(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                "city_name" => "required|min:3"
            ]);

        if ($validator->fails()) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, [], 'Lütfen Şehir Adını Doğru Giriniz');
        }

        $city = new Cities();
        $city->city_name = $request->input("city_name");
        $city->save();

        return $this->successResponse(Response::HTTP_OK, [], 'Şehir Başarılı Bir Şekilde Eklendi');
    }

    public function updateCity(Request $request, Cities $cities)
    {

        $validator = Validator::make($request->all(),
            [
                "city_name" => "required|min:3"
            ]);

        if ($validator->fails()) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, [], 'Lütfen Şehir Adını Doğru Giriniz');
        }

        $cities->update(["city_name" => $request->input("city_name")]);
        return $this->successResponse(Response::HTTP_OK, [], 'Şehir Başarılı Bir Şekilde Güncellendi');

    }

    public function deleteCity(Cities $cities)
    {
        $cities->delete();
        return $this->successResponse(Response::HTTP_OK, [], 'Şehir Silme İşlemi Başarılı');
    }

    public function searchCity(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                "q" => "required|min:1"
            ]);

        if ($validator->fails()) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, [], 'Lütfen Şehir Adını Doğru Giriniz');
        }

        $citySearch = Cities::searchCity($request)->get();
//        $citySearch = Cities::where('city_name', 'LIKE', '%' . $request->input("q") . '%')->get();
        return $this->successResponse(Response::HTTP_OK, $citySearch, 'Arama Sonucunuz');
    }
}
