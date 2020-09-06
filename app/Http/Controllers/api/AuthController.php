<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;
use App\Services;
use App\Contact;
use Validator;
use Hash;
use App\Notification;
use App\Setting;
use Illuminate\Support\Facades\Auth;
use App\Repository\NotificationsRepository;

class AuthController extends Controller
{
     public function registerPhone(Request $request)
    {
        //dd('dddd');
         $validator= validator()->make($request->all(),[
            'phone'  => 'required|unique:users',
            'email'  => 'required|unique:users',
            'name'  => 'required'
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
                                }
            $data =  $request->except('code','api_token','image');
            $data['code'] = mt_rand(1000,9999);
            $data['api_token'] = Str::random(60);
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
             return response()->json([ 'msg'=>'success' , 'data' => [
                 'id'  => $user->id,
                 'name' => $user->name,
                 'phone' => $user->phone,
                 'image' => $user->image,
                 'gender' => $user->gender,
                 'birthday' => $user->birthday,
                 'code' => $user->code,
                 'type' => $user->type,
                 'is_active' => $user->is_active,
                 'is_online' => $user->is_online,
                 'country_id' => $user->country_id,
                 'email' => $user->email,
                 'email_verified_at' => $user->email_verified_at,
                 'api_token' => $user->api_token,
                 'device_token' => $user->device_token,
                 'google_token'   => $user->google_token,
                 'fc_token'   => $user->fc_token,
                 'created_at'   => $user->created_at,
                 'updated_at'   => $user->updated_at,
                 ]]);
     
    }
    public function activcodeuser(Request $request)
     {  
      		$validator= validator()->make($request->all(),[
            'phone'  => 'required|exists:users,phone',
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
            $useractive = User::where([['code',$request->code],['phone', $request->phone ]])->first();
            if($useractive)
            {   
                $useractive->is_active = 1 ;
                 $useractive->save();
            	
                return response()->json([ 'msg'=>'success' , 'data' => $useractive]);
            }
            else 
            {
                $errorarr = array();
                return response()->json([ 'msg'=>'false' , 'data' => 'false Code']);
            }    
        
     }
     public function login(Request $request){
        $validator = Validator::make($request->all(), [
             'password'     => 'required|min:8',
             'email'     => 'required|exists:users,email',
        ]);
        if($validator->fails()){
            return response(['msg' =>'false' ,'data' => $validator->messages()]);
        }else {
            if (auth()->attempt(['email' =>$request->input('email'),'password' =>$request->input('password')]) ){
                $user = auth()->user();
                $user->device_token = $request->device_token;
                $user->is_online = 1;
                $user->save();
                	$notification = Notification::create([
                  'from_id'   => $user->id,
                  'type'     => 5,
                  'body' => '  مرحبا بك في بلاك ويلز '.$user->name,
                  ]); 
            if (!empty($useractive->device_token)){
                      NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->body, ['from_id' => $notification->from_id , 'status' => ' تعليق جديد   ']);
                   }
                 return response()->json([ 'msg'=>'success' , 
                       'data' => $user
                    //   [
                    //         'id'           => $user->id,
                    //         'name'         => $user->name ,
                    //         'phone'        => $user->phone ,
                    //         'device_token' => $user->device_token ,
                    //         'api_token'    => $user->api_token,
                    //       'is_online'   => $user->is_online,
                    //       'is_active'        => $user->is_active,
                            
                    //     ] 
                        
                        ]);
            }else {
                return response(['msg' =>"false" ,'data' => 'Unauthorised']);
            }
        }
    }//end login function
    public function reset(Request $request){

        $validator = Validator::make($request->all(),[
            'phone' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['msg' => 'false', 'data'=> $validator->errors()]);
        }
        $user = User::where('phone', $request->phone)->first();
        if($user){
            $code = rand(1111,9999);
            $user->code = $code;
            $user->save();
            try{
            //dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
          AuthController::sendSMS('Saaqr Verify Code :'.$user->code, $user->phone);
            // dd(UserController::sendSMS('elnawras code :'.$verifyData['code'], $user->phone) );
        }catch(\Exception $e){}
            return response()->json([   'msg' => 'success',
                         'data' => [
                              'code' => $code,
                              'phone' => $user->phone,
                             ],
                       
                    ]);
        }else{
            return response()->json(['msg' => 'false' , 'data' => ' No phone similar to the one you entered']);
        }
    }
    public function resetPassword(Request $request){

        $validator = Validator::make($request->all(),[
            'phone' => 'required',
            'password'     => 'required|min:6',
        ]);
        if($validator->fails()){
            return response()->json(['msg' => 'false', 'data'=> $validator->errors()]);
        }
        $user = User::where('phone', $request->phone)->first();
        if($user){
            $user->password = Hash::make($request->password);
            $user->save();
             $user->save();
                	$notification = Notification::create([
                  'from_id'   => $user->id,
                  'type'     => 6,
                  'body' => '   تم تغير كلمة السر الخاصه بك بنجاح '.$user->name,
                  ]); 
            if (!empty($useractive->device_token)){
                      NotificationsRepository::pushNotification($user->device_token, 'تعليق جديد', $notification->body, ['from_id' => $notification->from_id , 'status' => ' تعليق جديد   ']);
                   }
            return response()->json([   'msg' => 'success','data' => 'تم تغير الرقم السري ']);
        }else{
            return response()->json(['msg' => 'false' , 'data' => ' No phone similar to the one you entered']);
        }
    }
   public function editUser(Request $request )
    {
       
       
        $user = User::where([ 'id' => $request->user_id])->first();
        if(is_null($user)){
            return response()->json(['msg'=>false ,'data'=>'not found recourd']);
        }
        $user->name  = isset($request->name)? $request->name :  $user->name;
        $user->phone   = isset($request->phone)? $request->phone :  $user->phone;
         if ($request->hasFile('imageProfile')) {
            $filename = time() . '-' . $request->imageProfile->getClientOriginalName();
            $request->imageProfile->move(public_path('pictures/users'), $filename);
            $user->imageProfile = $filename;
            }
        
        if($user){
            $user->save(); 
        }
        return response()->json([ 'msg'=>'success' , 'data' => $user ]);
    }
     public function setting(){
      $arr = array();
      $settings0 = Setting::where(['key'=>'aboutApp'])->value('value');
      $settings1 = Setting::where(['key'=>'WarningText'])->value('value');
     // $settings2 = Setting::where(['key'=>'aboutApp3'])->value('value');
      $settings3 = Setting::where(['key'=>'conditions'])->value('value');
      $settings4 = Setting::where(['key'=>'who'])->value('value');
      //dd($settings); 
          array_push($arr, array(
               "splash–1"=>$settings0,
               "WarningText"=>$settings1,
               
               "conditions"=>$settings3,
               "who"=>$settings4,
          ));
          return response()->json(['msg'=>'success','data'=>$arr]);
    }  
    public function contact(Request $request){

      $validator= validator()->make($request->all(),[
            'phone'  => 'required|numeric',
            'message'  => 'required|max:250',
            'name'  => 'required|max:120',
            ]);
            
           if($validator->fails()){
            //422 not validation
            return response()->json(['msg' =>'false','data'=>$validator->errors()]);
                                }
            // $data =  $request->all();
            /// dd($request->name);
            // $contact = Contact::create($data);
                $data = new Contact();
                $data->name = $request->name;             
                $data->phone = $request->phone;             
                $data->message = $request->message;
                $data->save();              
            //dd($data);
             return response()->json([ 'msg'=>'success' , 'data' => $data]);
    }
    
     public function profileUser(Request $request)
    {
        
        $user = User::where('id',$request->user_id)->first();
        if( $user->is_provider == 1){
            //dd($user->is_provider);
            $provider = Services::where('user_id',$user->id)->first();
            return response()->json(['msg'=>'success','data' => [
                
                "user" =>$user,
                "provider" =>$provider,
                ]]);
        }else{
            return response()->json(['msg'=>'success','data' => $user]);
        }
        
    }
   public function logout(Request $request)
    {
    	$validator = Validator::make($request->all(), [
          'user_id' => 'required|numeric|exists:users,id',
        ]);

        if($validator->fails())
        {
            return response()->json(['msg' => 'error' , 'data' => $validator->errors()]);        
        }
        $reservation = User::where('id',$request->user_id)->first();
        $reservation->onAvailable = 0 ;
        $reservation->device_token = 'nullll' ;
        $reservation->save();
         return response()->json([
                    'msg' => 'success',
                    'data' =>$reservation
                    
                    
                    ]);
    }

    public function logoutt(Request $request)
 {

 $request->user()->token()->revoke();
 return response()->json([
    'message' => 'Successfully logged out'
 ]);
 }
}