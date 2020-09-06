<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Advertising;
use App\User;
use App\Follow;
use App\Comment;
use App\Report;
use App\Contact;
use App\Notification;
use App\Favourt;

class UserController extends Controller
{
    public function profile(){
        
        $user = auth()->guard('api')->user();
        $adv = Advertising::where('user_id',$user->id)->count();
        $followingsCount = Follow::where('user_id',$user->id)->get()->count();
        $followersCount = Follow::where('following_id',$user->id)->get()->count();
        return response()->json(['msg'=>'success','data'  => [
            'name' => $user->name,
            'image' => $user->image,
            'advCount' => $adv,
            'followingCount' => $followingsCount,
            'followersCount' => $followersCount,
            'dateCreate' => $user->created_at,
            ]] );
    }
    public function editProfile(Request $request)
    {
        $validator= validator()->make($request->all(),[
           'phone'  => 'required|unique:users',
            'email'  => 'required|unique:users',
            'name'  => 'required'  
             
            ]);
            
          if($validator->fails()){
           
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
        }
       $user = auth()->guard('api')->user();
        $user = User::where([ 'id' => $user->id])->first();
        if(is_null($user)){
            return response()->json(['msg'=>false ,'data'=>'not found recourd']);
        }
        $user->name       = $request->name;
        $user->phone      = $request->phone;
        $user->email      = $request->email;
        $user->gender     = $request->gender;
        $user->birthday     = $request->birthday;
        $user->password   = bcrypt($request->password);
        $user->is_active  = 1 ;
        $user->is_online  = 1 ;
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/users'), $filename);
            $user->image = $filename;
        }
        if($user){
            $user->save(); 
        }
        return response()->json([ 'msg'=>'success' , 'data' => $user ]);
    }
    public function profileUser(Request $request){
        $arr = array();
        $userr = auth()->guard('api')->user();
        $user = User::with('advertisement')->where('id',$request->user_id)->first();
        $followingCount = Follow::where('user_id',$user->id)->get()->count(); 
        $followerCount = Follow::where('following_id',$user->id)->get()->count(); 
        // $adv = Advertising::where('user_id', $user->id )->get();
        // $fav = Favourt::where(['adv_id'=>$adv->id, 'user_id' => $userAuth->id ]);
        // if(!empty($fav) and $userr ){
        //     $is_love = 1;    
        // }else{
        //     $is_love = 0 ;  
        // }
        return response()->json(['msg'=>'success','data'  =>[
            'user' =>  $user,
            'followingCount' =>$followingCount,
            'followerCount' =>$followerCount,
            
            ]]);
    }
    
    public function postComment(Request $request){
        $user = auth()->guard('api')->user();
        
         $validator= validator()->make($request->all(),[
            'comment'     => 'required',
            
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>"false",'data'=>$validator->errors()]);
                                }
        $data = $request->except('user_id');
        $data['user_id'] = $user->id;
        $comment = Comment::create($data);
        $adv   = Advertising::where('id',$comment->adv_id)->first();
        //dd($adv);
        $userAdv = User::where('id', $adv->user_id )->first();
        //dd($userAdv);
        $notification = Notification::create([
                  'from_id' => $user->id,
                  'to_id'   => $adv->user_id,
                  'ad_id'   => $adv->id,
                  'body' => ' تم عمل تعليق جديد من قبل  '.$user->name. ' على اعلانك'.$adv->title,
                    'type'    => 1,
                  ]); 
        if (!empty($userAdv->device_token)) {
                      NotificationsRepository::pushNotification($userAdv->device_token, 'تعليق جديد', $notification->body, ['to_id' => $notification->to_id , 'status' => ' تعليق جديد   ']);
                   }
        return response()->json(['msg'=>'success','data' => [
            'comment' => $comment,
            'notification' => $notification,
            ]]);
    }
    public function getComment(Request $request){
        $comments = Comment::with('user')->where('adv_id', $request->adv_id)->get();
        return response()->json(['msg'=>'success','data' =>$comments]);
        
    }
    public function reportUser(Request $request){
        
        $user = auth()->guard('api')->user();
        $report = Report::where(['user_id'=> $user->id , 'reported_id' => $request->reported_id ])->first();
        if(!$report){
            $data = $request->except('user_id');
            $data['user_id'] = $user->id;
            $report = Report::create($data);
        
            return response()->json(['msg'=>'success','data' => 'report user']);    
        }else{
           
            
        return response()->json(['msg'=>'success','data' => 'This user is already reported']);    
        }
        return response()->json(['msg'=>'false','data' => 'error']);
        
    }
    public function viewCount(Request $request){
     
            $adv = Advertising::where('id', $request->adv_id)->first();
            $adv->view_count = $adv->view_count+1;
            $adv->save();
              return response()->json(['msg'=>'success','data' =>
              $adv->view_count ]);
    }
    public function contactUS(Request $request)
    {
        $user = auth()->guard('api')->user();
        $validator= validator()->make($request->all(),[  
            'name' => 'required',   
            'phone' => 'required',   
            'body' => 'required',    
            
            ]);
            
           if($validator->fails()){
           
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
        }
        $data = $request->except(['user_id']);
        $data['user_id'] = $user->id ;
        $msgs = Contact::create($data);
        return response()->json([ 'msg'=>'success' , 
                       'data' => $msgs
                        
                        ]);
     
    }
    
}
