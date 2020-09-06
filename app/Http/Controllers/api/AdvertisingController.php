<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advertising;
use App\Details;
use App\Image;
use App\Category;
use App\SubCategory;
use App\Follow;
use App\User;
use App\Brand;
use App\Section;
use App\Notification;
use App\Comment;
use App\ChatMessage;
use App\Country;
use App\City;
use App\Area;
use App\Favourt;
use App\Repository\NotificationsRepository;
class AdvertisingController extends Controller
{
    public function addAdvertising(Request $request){
    	 
    	  $user = auth()->guard('api')->user();
          $data = $request->except('user_id','image','code_number');
          $data['user_id'] = $user->id;
          if ($request->hasFile('image')){
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/advertisement'), $filename);
            $data['image'] = $filename;
        }
        $data['code_number'] = rand() ;
          $advertising = Advertising::create($data);
          if ( $request->hasFile('images')){
            foreach (request('images') as $image){
            $images = new Image;
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('pictures/images'), $filename);
            $images->image = $filename;
            $images->advertising_id = $advertising->id;
            $images->save();
            }
        
        }
        if( $request->has('details')){
//dd($request->details);
            $details = request('details'); 
            $details = json_decode($details);
            for ($i=0; $i <count($details->details); $i++){
                $det = new Details;
                $det->key = $details->details[$i]->key ;    
                $det->value = $details->details[$i]->value ;    
                $det->advertising_id = $advertising->id ;
                $det->save();
            }
        }
        if(!empty($advertising->price)){
            $advertising->is_price = 1;
            $advertising->save();
        }
        if($request->hasFile('images')){
            $advertising->is_photos = 1;
            $advertising->save();
        }
            //dd($advertising->user_id);
        $followers = Follow::where('following_id',$advertising->user_id)->get();
        //dd($followers);
        foreach($followers as $follower){
            $userr = User::where('id' , $follower->following_id )->first();
            $notification = Notification::create([
                  'from_id' => $follower->following_id,
                  'to_id'   => $follower->user_id,
                  'ad_id'   => $advertising->id,
                  'body' => ' تم عمل اعلان جديد من قبل '.$userr->name,
                    'type'    => 2,
                  ]); 
        if (!empty($user->device_token)) {
                      NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->body, ['to_id' => $notification->to_id , 'status' => ' تعليق جديد   ']);
                   }
        }
          return response()->json(['msg'=>'success','data' => [
           'advertising' => $advertising,
           ]
           ] );
    }
    public function updateAdvertising(Request $request){
    	 
    	  $user = auth()->guard('api')->user();
    	  $adv = Advertising::where('id',$request->adv_id)->first();
          $data = $request->except('user_id','image','code_number');
          $data['user_id'] = $user->id;
          if ($request->hasFile('image')){
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/advertisement'), $filename);
            $data['image'] = $filename;
        }
          $data['code_number'] = rand() ;
          $advertising = $adv->update($data);
          if ( $request->hasFile('images')){
            foreach (request('images') as $image){
            $images = new Image;
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->move(public_path('pictures/images'), $filename);
            $images->image = $filename;
            $images->advertising_id = $adv->id;
            $images->save();
            }
        
        }
        if ( $request->hasFile('details')){
            $details = request('details'); 
            $details = json_decode($details);
            for ($i=0; $i <count($details->details); $i++) {
                $det = new Details;
                $det->key = $details->details[$i]->key ;    
                $det->value = $details->details[$i]->value ;    
                $det->advertising_id = $adv->id ;
                $det->save();
            }
        }
        if(!empty($advertising->price)){
            $adv->is_price = 1;
            $adv->save();
        }
        if($request->hasFile('images')){
            $adv->is_photos = 1;
            $adv->save();
        }
          return response()->json(['msg'=>'success','data' => [
           'advertising' => $adv,
           ]
           ] );
    }
    public function getAdv()
    {
      $arr = array();
        $advertising = Advertising::with('images')->with('details')->get();
        foreach($advertising as $adv){
          //$sections = Section::where('brand_id',$brand->id)->get();
            array_push($arr, array(
                  "advertising"=> $advertising,
            ));
     }
            
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
    public function getCategoryWithFiveAdvs(){
        $arr = array();
        $userarr = array();
        $categories = Category::all();
        foreach($categories as $category){
          
          $catAdvertising = Advertising::where(['category_id'=> $category->id ,'is_acceptance' => 1])->paginate(5);
          foreach($catAdvertising as $catAdv)
              $images = Image::where('advertising_id',$catAdv->id)->get();
              $details = Details::where('advertising_id',$catAdv->id)->get();
              $subcategory = SubCategory::where('id',$catAdv->subCategory_id)->first();
               $brand = Brand::where('id',$catAdv->brand_id)->first();
               $cat = Category::where('id',$catAdv->category_id)->first();
                $section = Section::where('id',$catAdv->class_id)->first();
                $user = User::where('id',$catAdv->user_id)->first();
                $country = Country::where('id',$catAdv->country_id)->first();
                $city = City::where('id',$catAdv->city_id)->first();
                $area = Area::where('id',$catAdv->area_id)->first();
               // dd($user);
                $followingsCount = Follow::where('user_id',$user->id)->get()->count();
                $followersCount = Follow::where('following_id',$user->id)->get()->count();
                 $advsCount = Advertising::where('user_id',$user->id)->get()->count();
                 $hasChat = ChatMessage::where(['to_id'=>$user->id ])->orWhere(['from_id'=> $user->id])->first();
                 $userAuth = auth()->guard('api')->user(); 
                if(!$userAuth){
                    $is_love = null;
                }else{
                    $fav = Favourt::where(['adv_id' =>$catAdv->id , 'user_id' => $userAuth->id ])->first();
                    
                    if(!empty($fav) and $userAuth ){
                        $is_love = 1;    
                    }else{
                        $is_love = 0 ;  
                    }
                    
                }
                array_push($userarr,array(
                    "ad"=>
                    array(
                        "id"=>$catAdv->id,
                        "code_number"=>$catAdv->code_number,
                        "price"=>$catAdv->price,
                        "phone"=>$catAdv->phone,
                        "title"=>$catAdv->title,
                        "image"=>$catAdv->image,
                        "description"=>$catAdv->description,
                        "user_id"=>$catAdv->user_id,
                        "category_id"=>$catAdv->category_id,
                        "subCategory_id"=>$catAdv->subCategory_id,
                        "brand_id"=>$catAdv->brand_id,
                        "class_id"=>$catAdv->class_id,
                        "country_id"=>$catAdv->country_id,
                        "city_id"=>$catAdv->city_id,
                        "area_id"=>$catAdv->area_id,
                        "is_photos"=>$catAdv->is_photos,
                        "is_price"=>$catAdv->is_price,
                        "is_acceptance"=>$catAdv->is_acceptance,
                        "created_at"=>$catAdv->created_at,
                        "updated_at"=>$catAdv->updated_at,
                        "country"=>$country->name,
                        "city"=>$city->name,
                        "area"=>$area->name,
                        "categoryName"=>$cat->name,
                        "subCategoryName"=>$subcategory->name,
                        "brandName"=>$brand->name,
                        "sectionName"=>$section->name,
                        'is_love'=> $is_love,
                        "images" => $images,
                        "details"=>$details,
                    
                 ),
                    "user"=>array("id"=>$user->id,
                    "name" => $user->name,
                    "image" => $user->image,
                    "phone" => $user->phone,
                    "gender" => $user->gender,
                    "birthday" => $user->birthday,
                    "code" => $user->code,
                    "email" => $user->email,
                    "api_token" => $user->api_token,
                    "device_token" => $user->device_token,
                    "is_online" => $user->is_online,
                    "followingsCount" => $followingsCount,
                    "followersCount"  => $followersCount,
                    "room_id"    => $hasChat->room_id,
                    "advsUserCount"    => $advsCount,
                     )
                    ));
                array_push($arr, array(
                  "category"     => $category,
                  "ad_details"=>$userarr,
                  
               
                
               ));  
          
              
     
            
        }
        return response()->json(['msg'=>'success','data' => $arr]);
        
    }
    public function getCatAdv(Request $request)
    {
         $arr = array();
         $userarr = array();
        $advertising = Advertising::with('images')->with('details')->where(['category_id'=> $request->category_id , 'is_acceptance'=>1 ] )->paginate(2);
        //dd($advertising);
            foreach($advertising as $catAdv){
              $images = Image::where('advertising_id',$catAdv->id)->get();
              $details = Details::where('advertising_id',$catAdv->id)->get();
              $subcategory = SubCategory::where('id',$catAdv->subCategory_id)->first();
               $brand = Brand::where('id',$catAdv->brand_id)->first();
               $cat = Category::where('id',$catAdv->category_id)->first();
                $section = Section::where('id',$catAdv->class_id)->first();
                $user = User::where('id',$catAdv->user_id)->first();
                $country = Country::where('id',$catAdv->country_id)->first();
                $city = City::where('id',$catAdv->city_id)->first();
                $area = Area::where('id',$catAdv->area_id)->first();
               // dd($user);
                $followingsCount = Follow::where('user_id',$user->id)->get()->count();
                $followersCount = Follow::where('following_id',$user->id)->get()->count();
                $advsCount = Advertising::where('user_id',$user->id)->get()->count();
                 $hasChat = ChatMessage::where(['to_id'=>$user->id ])->orWhere(['from_id'=> $user->id])->first();
                 $userAuth = auth()->guard('api')->user(); 
                if(!$userAuth){
                    $is_love = null;
                }else{
                    $fav = Favourt::where(['adv_id' =>$catAdv->id , 'user_id' => $userAuth->id ])->first();
                    
                    if(!empty($fav) and $userAuth ){
                        $is_love = 1;    
                    }else{
                        $is_love = 0 ;  
                    }
                    
                }
                array_push($userarr,array(
                    "ad"=>
                    array(
                        "id"=>$catAdv->id,
                        "code_number"=>$catAdv->code_number,
                        "price"=>$catAdv->price,
                        "phone"=>$catAdv->phone,
                        "title"=>$catAdv->title,
                        "image"=>$catAdv->image,
                        "description"=>$catAdv->description,
                        "user_id"=>$catAdv->user_id,
                        "category_id"=>$catAdv->category_id,
                        "subCategory_id"=>$catAdv->subCategory_id,
                        "brand_id"=>$catAdv->brand_id,
                        "class_id"=>$catAdv->class_id,
                        "country_id"=>$catAdv->country_id,
                        "city_id"=>$catAdv->city_id,
                        "area_id"=>$catAdv->area_id,
                        "is_photos"=>$catAdv->is_photos,
                        "is_price"=>$catAdv->is_price,
                        "is_acceptance"=>$catAdv->is_acceptance,
                        "created_at"=>$catAdv->created_at,
                        "updated_at"=>$catAdv->updated_at,
                        "country"=>$country->name,
                        "city"=>$city->name,
                        "area"=>$area->name,
                        "categoryName"=>$cat->name,
                        "subCategoryName"=>$subcategory->name,
                        "brandName"=>$brand->name,
                        "sectionName"=>$section->name,
                        'is_love'=> $is_love,
                        "images" => $images,
                        "details"=>$details,
                    
                 ),
                    "user"=>array("id"=>$user->id,
                    "name" => $user->name,
                    "image" => $user->image,
                    "phone" => $user->phone,
                    "gender" => $user->gender,
                    "birthday" => $user->birthday,
                    "code" => $user->code,
                    "email" => $user->email,
                    "api_token" => $user->api_token,
                    "device_token" => $user->device_token,
                    "is_online" => $user->is_online,
                    "followingsCount" => $followingsCount,
                    "followersCount"  => $followersCount,
                    "room_id"    => $hasChat->room_id,
                    "advsUserCount"    => $advsCount,
                     )
                    ));
                
            }
            array_push($arr, array(
                 
                  "ad_details"=>$userarr,
                  
               
                
               ));  
           return response()->json(['msg'=>'success','data' => $arr]);
         
    }
    public function getMyAds(Request $request){
        $arr = array();
        $userarr = array();
   		$userr = auth()->guard('api')->user();
   		$advertising = Advertising::with('images')->with('details')->where(['user_id'=>$userr->id , 'is_acceptance'=>1])->paginate(5);
        foreach($advertising as $catAdv)
              $images = Image::where('advertising_id',$catAdv->id)->get();
              $details = Details::where('advertising_id',$catAdv->id)->get();
              $subcategory = SubCategory::where('id',$catAdv->subCategory_id)->first();
               $brand = Brand::where('id',$catAdv->brand_id)->first();
               $cat = Category::where('id',$catAdv->category_id)->first();
                $section = Section::where('id',$catAdv->class_id)->first();
                $user = User::where('id',$catAdv->user_id)->first();
                $country = Country::where('id',$catAdv->country_id)->first();
                $city = City::where('id',$catAdv->city_id)->first();
                $area = Area::where('id',$catAdv->area_id)->first();
               // dd($user);
                $followingsCount = Follow::where('user_id',$user->id)->get()->count();
                $followersCount = Follow::where('following_id',$user->id)->get()->count();
                 $hasChat = ChatMessage::where(['to_id'=>$user->id ])->orWhere(['from_id'=> $user->id])->first();
                 $userAuth = auth()->guard('api')->user(); 
                if(!$userAuth){
                    $is_love = null;
                }else{
                    $fav = Favourt::where(['adv_id' =>$catAdv->id , 'user_id' => $userAuth->id ])->first();
                    
                    if(!empty($fav) and $userAuth ){
                        $is_love = 1;    
                    }else{
                        $is_love = 0 ;  
                    }
                    
                }
                array_push($userarr,array(
                    "ad"=>
                    array(
                        "id"=>$catAdv->id,
                        "code_number"=>$catAdv->code_number,
                        "price"=>$catAdv->price,
                        "phone"=>$catAdv->phone,
                        "title"=>$catAdv->title,
                        "image"=>$catAdv->image,
                        "description"=>$catAdv->description,
                        "user_id"=>$catAdv->user_id,
                        "category_id"=>$catAdv->category_id,
                        "subCategory_id"=>$catAdv->subCategory_id,
                        "brand_id"=>$catAdv->brand_id,
                        "class_id"=>$catAdv->class_id,
                        "country_id"=>$catAdv->country_id,
                        "city_id"=>$catAdv->city_id,
                        "area_id"=>$catAdv->area_id,
                        "is_photos"=>$catAdv->is_photos,
                        "is_price"=>$catAdv->is_price,
                        "is_acceptance"=>$catAdv->is_acceptance,
                        "created_at"=>$catAdv->created_at,
                        "updated_at"=>$catAdv->updated_at,
                        "country"=>$country->name,
                        "city"=>$city->name,
                        "area"=>$area->name,
                        "categoryName"=>$cat->name,
                        "subCategoryName"=>$subcategory->name,
                        "brandName"=>$brand->name,
                        "sectionName"=>$section->name,
                        'is_love'=> $is_love,
                        "images" => $images,
                        "details"=>$details,
                    
                 )
                    ));
                array_push($arr, array(
                 
                  "ad_details"=>$userarr,
                  
               
                
               ));  
            
        return response()->json(['msg'=>'success','data'  => $arr]);

   }
    public function getUserAds(Request $request){
        $arr = array();
        $userarr = array();
        $advertising = Advertising::where(['user_id'=>$request->user_id , 'is_acceptance'=>1])->paginate(5);
         foreach($advertising as $catAdv){
              $images = Image::where('advertising_id',$catAdv->id)->get();
              $details = Details::where('advertising_id',$catAdv->id)->get();
              $subcategory = SubCategory::where('id',$catAdv->subCategory_id)->first();
               $brand = Brand::where('id',$catAdv->brand_id)->first();
               $cat = Category::where('id',$catAdv->category_id)->first();
                $section = Section::where('id',$catAdv->class_id)->first();
                $user = User::where('id',$catAdv->user_id)->first();
                $country = Country::where('id',$catAdv->country_id)->first();
                $city = City::where('id',$catAdv->city_id)->first();
                $area = Area::where('id',$catAdv->area_id)->first();
               // dd($user);
                $followingsCount = Follow::where('user_id',$user->id)->get()->count();
                $followersCount = Follow::where('following_id',$user->id)->get()->count();
                $advsCount = Advertising::where('user_id',$user->id)->get()->count();
                 $hasChat = ChatMessage::where(['to_id'=>$user->id ])->orWhere(['from_id'=> $user->id])->first();
                 $userAuth = auth()->guard('api')->user(); 
                if(!$userAuth){
                    $is_love = null;
                }else{
                    $fav = Favourt::where(['adv_id' =>$catAdv->id , 'user_id' => $userAuth->id ])->first();
                    
                    if(!empty($fav) and $userAuth ){
                        $is_love = 1;    
                    }else{
                        $is_love = 0 ;  
                    }
                    
                }
                array_push($userarr,array(
                    "ad"=>
                    array(
                        "id"=>$catAdv->id,
                        "code_number"=>$catAdv->code_number,
                        "price"=>$catAdv->price,
                        "phone"=>$catAdv->phone,
                        "title"=>$catAdv->title,
                        "image"=>$catAdv->image,
                        "description"=>$catAdv->description,
                        "user_id"=>$catAdv->user_id,
                        "category_id"=>$catAdv->category_id,
                        "subCategory_id"=>$catAdv->subCategory_id,
                        "brand_id"=>$catAdv->brand_id,
                        "class_id"=>$catAdv->class_id,
                        "country_id"=>$catAdv->country_id,
                        "city_id"=>$catAdv->city_id,
                        "area_id"=>$catAdv->area_id,
                        "is_photos"=>$catAdv->is_photos,
                        "is_price"=>$catAdv->is_price,
                        "is_acceptance"=>$catAdv->is_acceptance,
                        "created_at"=>$catAdv->created_at,
                        "updated_at"=>$catAdv->updated_at,
                        "country"=>$country->name,
                        "city"=>$city->name,
                        "area"=>$area->name,
                        "categoryName"=>$cat->name,
                        "subCategoryName"=>$subcategory->name,
                        "brandName"=>$brand->name,
                        "sectionName"=>$section->name,
                        'is_love'=> $is_love,
                        "images" => $images,
                        "details"=>$details,
                    
                 ),
                    "user"=>array("id"=>$user->id,
                    "name" => $user->name,
                    "image" => $user->image,
                    "phone" => $user->phone,
                    "gender" => $user->gender,
                    "birthday" => $user->birthday,
                    "code" => $user->code,
                    "email" => $user->email,
                    "api_token" => $user->api_token,
                    "device_token" => $user->device_token,
                    "is_online" => $user->is_online,
                    "followingsCount" => $followingsCount,
                    "followersCount"  => $followersCount,
                    "room_id"    => $hasChat->room_id,
                    "advsUserCount"    => $advsCount,
                     )
                    ));}
                array_push($arr, array(
                
                  "ad_details"=>$userarr,
                  
               
                
               ));  
          
        return response()->json(['msg'=>'success','data'  => $arr]);

   }
   public function getAdvId(Request $request)
    {
        $arr = array();
        $advertising = Advertising::with('images')->with('details')->where(['id'=> $request->adv_id ,'is_acceptance'=>1 ] )->with('category')->with('user')->first();
       
      $simillarAdvs = Advertising::where(['category_id'=> $advertising->category_id , 'subCategory_id' => $advertising->subCategory_id ])->get();
      $comments = Comment::with('user')->where('adv_id',$advertising->id)->get();
           return response()->json(['msg'=>'success','data' => [
               'advertising' => $advertising,
               //'images'      => $images,
               //'details'     => $details,
               'simillarAdvs'=> $simillarAdvs,
               'comments' =>$comments,
               ]]);
         
    }
    public function filter(Request $request){
        $advs = Advertising::where('is_acceptance',1)->where(function ($q) use ($request) {
            if ($request->has('category_id'))  {
               
                $q->where('category_id', request('category_id'));
            }
            if ($request->has('category_id') and $request->has('subCategory_id')) {
                $q->where(['category_id'=> request('category_id') , 'subCategory_id'=> request('subCategory_id')]);
            }
             if ($request->has('category_id') and $request->has('subCategory_id') and $request->has('brand_id') ) {
                $q->where(['category_id'=> request('category_id') , 'subCategory_id'=> request('subCategory_id') ,'brand_id'=> request('brand_id')]);
            }
            if ($request->has('category_id') and  $request->has('brand_id')) {
                $q->where(['category_id'=> request('category_id') , 'brand_id'=> request('brand_id')]);
            }
            if ($request->has('category_id') and $request->has('subCategory_id') and $request->has('brand_id') and  $request->has('class_id')) {
                $q->where(['category_id'=> request('category_id')  , 'subCategory_id'=> request('subCategory_id') ,'brand_id'=> request('brand_id') ,'class_id' => request('class_id')]);
            }
             if ($request->has('category_id') and  $request->has('class_id')) {
                $q->where(['category_id'=> request('category_id') ,'class_id' => request('class_id')]);
            }
            if ($request->has('country_id')) {
               
                $q->Where('country_id', request('country_id'));
            }
            if ($request->has('country_id') and $request->has('city_id')) {
                $q->where(['country_id'=> request('country_id') ,'city_id' => request('city_id')]);
            }
            if ($request->has('country_id') and $request->has('city_id') and $request->has('area_id')){
                $q->where(['country_id'=> request('country_id') ,'city_id' => request('city_id'),'area_id' => request('area_id')]);
            }
             if ($request->has('country_id')  and $request->has('area_id')){
                $q->where(['country_id'=> request('country_id') ,'area_id' => request('area_id')]);
            }
            if ($request->has('minRange') && $request->has('maxRange')) {
                $price = [
                  request('minRange'),
                  request('maxRange')
              ];
               
                $q->whereBetween('price', $price);
            }
            if ($request->has('is_photos')) {
                $q->where('is_photos', 1);
            }
            if ($request->has('is_price')) {
                $q->where('is_price', 1);
            }
            if ($request->has('lowestPrice')) {
                $q->where('price', $q->min('price'));
            }
            if ($request->has('highestPrice')) {
                $q->where('price', $q->max('price'));
            }
            if ($request->has('newest')) {
                $q->latest();
            }
            
        })->orderBy('created_at', 'desc')->paginate(10);
       return response()->json([ 'msg'=>'success' , 'data' => [
            "advs" => $advs,
            ] ]);
        
    }
   public function sorting(Request $request){
             $advs = Advertising::where('is_acceptance',1)->where(function ($q) use ($request) {
            
            if ($request->has('lowestPrice')) {
                $q->where('price', $q->min('price'));
            }
             if ($request->has('lowestPrice') and  $request->has('highestPrice')) {
                $q->where(['price' => $q->max('price'),'price' => $q->min('price') ]);
            }
            if ($request->has('highestPrice')) {
                $q->where('price', $q->max('price'));
            }
            if ($request->has('newest')) {
                $q->latest();
            }
            if ($request->has('newest') and $request->has('lowestPrice') and  $request->has('highestPrice')) {
                $q->where(['price' => $q->max('price'),'price' => $q->min('price') ])->latest();
            }
            
        })->orderBy('created_at', 'desc')->paginate(10);
       return response()->json([ 'msg'=>'success' , 'data' => [
            "advs" => $advs,
            ] ]);
       
   }
    public function searchTitleAdvs(Request $request)
    {
         $arr = array();
        
         $search = Advertising::with('user')->where('title','like','%'.$request['title'].'%')->orderBy('created_at', 'desc')->paginate(10);
        
        foreach($search as $sh){
        array_push($arr, array(
              "adv"=> $sh,
        ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }
    public function searchNameCat(Request $request)
    {
         $arr = array();
        
         $search = Category::where('name','like','%'.$request['name'].'%')->get();
        
        foreach($search as $sh){
        array_push($arr, array(
              "category"=> $sh,
        ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }
     public function searchNameSubCat(Request $request)
    {
         $arr = array();
        
         $search = SubCategory::where('name','like','%'.$request['name'].'%')->get();
        
        foreach($search as $sh){
        array_push($arr, array(
              "subCategory"=> $sh,
        ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }
    public function searchNameBrand(Request $request)
    {
         $arr = array();
        
         $search = Brand::where('name','like','%'.$request['name'].'%')->get();
        
        foreach($search as $sh){
        array_push($arr, array(
              "brand"=> $sh,
        ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }
     public function searchNameClass(Request $request)
    {
         $arr = array();
        
         $search = Section::where('name','like','%'.$request['name'].'%')->get();
        
        foreach($search as $sh){
        array_push($arr, array(
              "section"=> $sh,
        ));
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }
     public function destroyAdv(Request $request){
        
        $noty = Advertising::where([ ['id', $request->advertising_id]])->first();
        if(is_null($noty)){
    		return response()->json(['msg'=>'not found recourd' , 'data' => 404]);
    	}
    	$noty->delete();
       //dd($occasions);
      
        
        return response()->json([ 'msg'=>'deleted' , 'data' => 402 ]);
    }
    public function getSimmillarAdvs(Request $request){
        
        $arr = array();
        $userarr = array();
        $advertising = Advertising::where(['id'=> $request->adv_id ,'is_acceptance'=>1 ] )->first();
      $simillarAdvs = Advertising::where(['category_id'=> $advertising->category_id , 'subCategory_id' => $advertising->subCategory_id ])->paginate(5);
       foreach($simillarAdvs as $catAdv)
              $images = Image::where('advertising_id',$catAdv->id)->get();
              $details = Details::where('advertising_id',$catAdv->id)->get();
              $subcategory = SubCategory::where('id',$catAdv->subCategory_id)->first();
               $brand = Brand::where('id',$catAdv->brand_id)->first();
               $cat = Category::where('id',$catAdv->category_id)->first();
                $section = Section::where('id',$catAdv->class_id)->first();
                $user = User::where('id',$catAdv->user_id)->first();
                $country = Country::where('id',$catAdv->country_id)->first();
                $city = City::where('id',$catAdv->city_id)->first();
                $area = Area::where('id',$catAdv->area_id)->first();
               // dd($user);
                $followingsCount = Follow::where('user_id',$user->id)->get()->count();
                $followersCount = Follow::where('following_id',$user->id)->get()->count();
                 $hasChat = ChatMessage::where(['to_id'=>$user->id ])->orWhere(['from_id'=> $user->id])->first();
                 $userAuth = auth()->guard('api')->user(); 
                if(!$userAuth){
                    $is_love = null;
                }else{
                    $fav = Favourt::where(['adv_id' =>$catAdv->id , 'user_id' => $userAuth->id ])->first();
                    
                    if(!empty($fav) and $userAuth ){
                        $is_love = 1;    
                    }else{
                        $is_love = 0 ;  
                    }
                    
                }
                array_push($userarr,array(
                    "ad"=>
                    array(
                        "id"=>$catAdv->id,
                        "code_number"=>$catAdv->code_number,
                        "price"=>$catAdv->price,
                        "phone"=>$catAdv->phone,
                        "title"=>$catAdv->title,
                        "image"=>$catAdv->image,
                        "description"=>$catAdv->description,
                        "user_id"=>$catAdv->user_id,
                        "category_id"=>$catAdv->category_id,
                        "subCategory_id"=>$catAdv->subCategory_id,
                        "brand_id"=>$catAdv->brand_id,
                        "class_id"=>$catAdv->class_id,
                        "country_id"=>$catAdv->country_id,
                        "city_id"=>$catAdv->city_id,
                        "area_id"=>$catAdv->area_id,
                        "is_photos"=>$catAdv->is_photos,
                        "is_price"=>$catAdv->is_price,
                        "is_acceptance"=>$catAdv->is_acceptance,
                        "created_at"=>$catAdv->created_at,
                        "updated_at"=>$catAdv->updated_at,
                        "country"=>$country->name,
                        "city"=>$city->name,
                        "area"=>$area->name,
                        "categoryName"=>$cat->name,
                        "subCategoryName"=>$subcategory->name,
                        "brandName"=>$brand->name,
                        "sectionName"=>$section->name,
                        'is_love'=> $is_love,
                        "images" => $images,
                        "details"=>$details,
                    
                 ),
                    "user"=>array("id"=>$user->id,
                    "name" => $user->name,
                    "image" => $user->image,
                    "phone" => $user->phone,
                    "gender" => $user->gender,
                    "birthday" => $user->birthday,
                    "code" => $user->code,
                    "email" => $user->email,
                    "api_token" => $user->api_token,
                    "device_token" => $user->device_token,
                    "is_online" => $user->is_online,
                    "followingsCount" => $followingsCount,
                    "followersCount"  => $followersCount,
                    "room_id"    => $hasChat->room_id,
                     )
                    ));
                array_push($arr, array(
                 
                  "ad_details"=>$userarr,
                  
               
                
               ));  
      return response()->json(['msg'=>'success','data' => $arr]);
    }
    
}
