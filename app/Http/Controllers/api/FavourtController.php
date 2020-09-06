<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Follow;
use App\User;
use App\Favourt;
use App\Advertising;
use App\Notification;
use App\Comment;
use App\Image;
use App\Details;
use App\SubCategory;
use App\Brand;
use App\Category;
use App\Section;
use App\Country;
use App\City;
use App\Area;
use App\ChatMessage;
use App\Repository\NotificationsRepository;

class FavourtController extends Controller
{
   public function addFollow(Request $request){

   		$user = auth()->guard('api')->user();
   		//dd($user->id);
   		$validator= validator()->make($request->all(),[
            'following_id'     => 'required',
            ]);
            
           if($validator->fails()){
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
            $follow = new Follow;
            $follow->user_id = $user->id;
            $follow->following_id = $request->following_id;
        	$follow->save();
        	$followerUser = User::where('id', $follow->following_id)->first();
        	$notification = Notification::create([
                  'from_id' => $user->id,
                  'to_id'   => $follow->following_id,
                  'body' => ' تم عمل متابعه من قبل '.$user->name,
                    'type'    => 3,
                  ]); 
            if (!empty($followerUser->device_token)){
                      NotificationsRepository::pushNotification($followerUser->device_token, 'تعليق جديد', $notification->body, ['to_id' => $notification->to_id , 'status' => ' تعليق جديد   ']);
                   }
            return response()->json(['msg'=>'success','data'  => $follow] );

   }
   
   public function addLove(Request $request){

   		$user = auth()->guard('api')->user();
   		//dd($user->id);
   		$validator= validator()->make($request->all(),[
            'adv_id'     => 'required',
            ]);
            
           if($validator->fails()){
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
            $fav = new Favourt;
            $fav->user_id = $user->id;
            $fav->adv_id = $request->adv_id;
        	$fav->save();
        	$adv = Advertising::where('id', $fav->adv_id )->first();
        	$advUser = User::where('id',$adv->user_id)->first();
        	$notification = Notification::create([
                  'from_id' => $user->id,
                  'to_id'   => $advUser->id,
                  'ad_id'   => $adv->id,
                  'body' => ' تم عمل  مفضلة لاعلانك من قبل '.$advUser->name,
                    'type'    => 4, ]); 
            if (!empty($advUser->device_token)){
                      NotificationsRepository::pushNotification($advUser->device_token, 'تعليق جديد', $notification->body, ['to_id' => $notification->to_id , 'status' => ' تعليق جديد   ']);
                   }
            return response()->json(['msg'=>'success','data'  => $fav] );

   }
   public function getMyLoveAdv(Request $request){

   		$user = auth()->guard('api')->user();
   		$arr = array();
   		$userarr = array();
   		$advsFavs = Favourt::where('user_id',$user->id)->get();
   		//dd($advsFavs);
         foreach($advsFavs as $category){
          
          $catAdvertising = Advertising::where(['id'=> $category->adv_id ,'is_acceptance' => 1])->paginate(5);
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
         }
                array_push($arr, array(
                  
                  "ad_details"=>$userarr,
                  
               
                
               ));  
          
              
     
            
        
        return response()->json(['msg'=>'success','data' => $arr]);
      

   }
  
   public function getMyFollowing(Request $request){
        $arr = array();
        $userarr = array();
   		$userr = auth()->guard('api')->user();
   		$followings = Follow::where('user_id',$userr->id)->paginate(2);
   	    
        foreach($followings as $following){
          $userFollowingData = User::where('id', $following->following_id)->first();
          $catAdvertising = Advertising::where(['user_id'=> $following->following_id ,'is_acceptance' => 1])->take(5)->get();
          $countAdvertisingFollowing = Advertising::where(['user_id'=> $following->following_id ,'is_acceptance' => 1])->count();
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
                 "user_data" => $userFollowingData,
                  "ad_details"=>$userarr,
                  "countAdvertisingFollowing" => $countAdvertisingFollowing,
               
                
               ));  
          
              
     
            
        }
        return response()->json(['msg'=>'success','data'  => $arr]);

   }
   public function getMyFollowers(Request $request){

   		$user = auth()->guard('api')->user();
   		$arr = array();
   		$followings = Follow::where('following_id',$user->id)->paginate(2);
   
        return response()->json(['msg'=>'success','data'  => $followings]);

   }
   public function searchFollowerName(Request $request)
    {
         $arr = array();
         $arr1 = array();
         $user = auth()->guard('api')->user();
         $followers = Follow::where(['following_id'=> $user->id])->get();
         //dd($followers);
        foreach($followers as $follower){
            $usersData = User::where('id', $follower->user_id)->where('name','like','%'.$request['name'].'%')->get();
            foreach($usersData as $userData){
                //dd($userData);
                 array_push($arr1, array(
                     'followerId'=>$userData->id,
                     'followerName'=>$userData->name,
                     'followerImage'=>$userData->image,
                     'followerIsOnline'=>$userData->is_online,
                    ));
            }
                
    }
        //echo dd($questions);
        return response()->json(['msg'=>'success','data' => $arr1]);
      
    }
    
    public function getNotfy(Request $request){
        $arr = array();
        $arr1 = array();
        $arr2 = array();
        $user = auth()->guard('api')->user();
        $myNotifications = Notification::where([['from_id', $user->id]])->orderBy('created_at', 'DESC')->get();
        foreach($myNotifications as $myNotification)
        {
            
                $advs = Advertising::where('id' ,$myNotification->ad_id)->get();
                foreach($advs as $adv){
                    array_push($arr, array(
                      "myNotification"=> $myNotification,
                        "advId"                  => $adv->id,
                      
                ));   
                }
        }
        // $myNotificationsFollowingAdvs = Notification::where([['from_id', $user->id] , ['type', 2]])->get();
        // foreach($myNotificationsFollowingAdvs as $myNotificationsFollowingAdv)
        // {
            
        //         $advs = Advertising::where('id' ,$myNotificationsFollowingAdv->ad_id)->get();
        //         foreach($advs as $adv){
        //             array_push($arr1, array(
        //               "myNotificationsFollowingAdv" => $myNotificationsFollowingAdv,
        //                 "advId"     => $adv->id,
                      
        //         ));   
        //         }
            
        // }
        $myNotificationsFollowingUser = Notification::where([['from_id', $user->id] , ['type', 3]])->orderBy('created_at', 'DESC')->get();
        foreach($myNotificationsFollowingUser as $myNotfy)
        {
        $userFollowing = User::where('id' ,$myNotfy->to_id)->first();
                    array_push($arr2, array(
                      "myNotificationsFollowingUser"=> $myNotificationsFollowingUser,
                        "userFollowing"     => $userFollowing,
                      
                ));   
        }        
        return response()->json(['msg'=>'success','data' => [
            'myNotificationsType1&2&4' => $arr,
            // 'myNotificationsFollowingAdv'=>$arr1,
            "myNotificationsType3" => $arr2,
            ]]);
        
    }
     public function destroyNotfy(Request $request){
        
        $noty = Notification::where([ ['id', $request->notification_id]])->first();
        if(is_null($noty)){
    		return response()->json(['msg'=>'not found recourd' , 'data' => 404]);
    	}
    	$noty->delete();
       //dd($occasions);
      
        
        return response()->json([ 'msg'=>'deleted' , 'data' => 402 ]);
    }
    public function removLove(Request $request){
        $user = auth()->guard('api')->user();
   		$validator= validator()->make($request->all(),[
            'adv_id'     => 'required',
            ]);
            
           if($validator->fails()){
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
            $fav = Favourt::where(['adv_id'=>$request->adv_id , 'user_id' => $user->id ])->first();
        	if(is_null($fav)){
    		return response()->json(['msg'=>'false' , 'data' => 404]);
    	}
    	$fav->delete();
        return response()->json(['msg'=>'success','data'  => 'deleted'] );
    }
}
