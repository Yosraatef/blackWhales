<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;
use App\Category;
use App\City;
use App\Area;
use App\Brand;
use App\Section;
use App\SubCategory;
use App\Advertising;
use App\Repository\NotificationsRepository;

class HomeController extends Controller
{
    
    public function allCountry()
    {
      $arr = array();
        $countries = Country::all();
        foreach($countries as $country){
            array_push($arr, array(
                  "id"=> $country->id,
                  "name" => $country->name,
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
     public function cityCountry(Request $request)
    {
      $arr = array();
        $cities = City::where('country_id',$request->country_id)->get();
        foreach($cities as $city){
            array_push($arr, array(
                  "id"=> $city->id,
                  "name" => $city->name,
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
     public function areaCity(Request $request)
    {
        $arr = array();
        $cities = Area::where('city_id',$request->city_id)->get();
        foreach($cities as $city){
            array_push($arr, array(
                  "id"=> $city->id,
                  "name" => $city->name,
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
    public function getCategory()
    {
        $arr = array();
        $categories = Category::paginate(5);
       
           return response()->json(['msg'=>'success','data'=> $categories]);
         
    }
    public function getSubCategory(Request $request)
    {
        $arr = array();
        $subCategories = SubCategory::where('category_id', $request->category_id)->paginate(5);
       
           return response()->json(['msg'=>'success','data'=> $subCategories]);
         
    }
    public function getBrand(Request $request)
    {
      
        $brands = Brand::where('subCategory_id', $request->subCategory_id)->paginate(5);
    
           return response()->json(['msg'=>'success','data' => $brands]);
         
    }
    public function getSection(Request $request)
    {
      
        $sections = Section::where('brand_id', $request->brand_id)->paginate(5);
    
           return response()->json(['msg'=>'success','data' => $sections]);
         
    }

    

    
}
