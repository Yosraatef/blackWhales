<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banner;
class BannerController extends Controller
{
    public function getBanner(){
    	$arr = array();
        $banners = Banner::all();
        foreach($banners as $banner){
            array_push($arr, array(
                  "id"=> $banner->id,
                  "text" => $banner->text,
                  "image" => $banner->image,  
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
    }
}
