<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ChatRoom;
use App\ChatMessage;
use App\User;
use App\Follow;
use App\Repository\NotificationsRepository;

class ChatController extends Controller
{
     public function addmassage(Request $request)
      {    
          //dd($request->image);
          $user = auth()->guard('api')->user();
           $validator= validator()->make($request->all(),[
            'to_id' => 'required|exists:users,id',   
             
            ]);
            
          if($validator->fails()){
           
            return response()->json(['msg' =>false,'data'=>$validator->errors()]);
         }
         
            $hasChat = ChatRoom::where(['to_id'=>$request->to_id ,'from_id'=> $user->id])->orWhere(['from_id'=> $request->to_id , 'to_id'=>$user->id])->first();
           
            $uphasChat = ChatMessage::where(['to_id'=>$request->to_id ,'from_id'=> $user->id])->orWhere(['from_id'=> $request->received_id , 'to_id'=>$user->id])->first();
           
              if(empty($hasChat) and empty($uphasChat)){
                  $room = new ChatRoom;
                  $room->to_id = $request->to_id;
                  if(!empty($user->id)) {          
                  $room->from_id = $user->id;
                  $room->save();
                  }else{
                    return response()->json([ 'msg'=>'success' , 'data' => 'يجب التسجيل الدخول' ]);
                  }
                  
                  $message = new ChatMessage;
                  $message->to_id =  $request->to_id;
                  $message->from_id = $user->id;
                  $message->room_id = $room->id;
                  if($request->type == 0){
                    $message->message = $request->message;
                    $message->type = 0;
                    }else{
                        if ($request->hasFile('image')) {
                            $filename = time() . '-' . $request->image->getClientOriginalName();
                            $request->image->move(public_path('pictures/chat'), $filename);
                            $message->image = $filename;
                        }  
                        $message->type = 1;
                    }
                  $message->save();
                  $receivedUser = User::where('id',$message->to_id)->first();
                   if (!empty($receivedUser->device_token)){
                      NotificationsRepository::pushNotification($receivedUser->device_token, 'رسالة جديدة', ['to_id' => $message->to_id , 'status' => ' تعليق جديد   ']);
                   }
                  return response()->json([ 'msg'=>'success' , 'data' => [
                      
                      'room' =>$room,
                      'message' => $message,
                      
                      ] ]);
              }else{
                if($request->type == 0){
                    $uphasChat->message = $request->message;
                    $uphasChat->type = 0;
                    
                }else{
                    if ($request->hasFile('image')) {
                        $filename = time() . '-' . $request->image->getClientOriginalName();
                        $request->image->move(public_path('pictures/chat'), $filename);
                        $uphasChat->image = $filename;
                    }  
                    $uphasChat->type = 1;
                }
               $uphasChat->save();
               $receivedUser = User::where('id',$uphasChat->to_id)->first();
            if (!empty($receivedUser->device_token)){
                      NotificationsRepository::pushNotification($receivedUser->device_token, 'رسالة جديدة', ['to_id' => $message->to_id , 'status' => ' تعليق جديد   ']);
                   }
                return response()->json([ 'msg'=>'success' , 'data' =>$uphasChat]);
              }
      }
    public function profileChate(Request $request){
        
        $user = auth()->guard('api')->user();
            $hasChat = ChatRoom::where(['to_id'=>$request->to_id ,'from_id'=> $user->id])->orWhere(['from_id'=> $request->to_id , 'to_id'=>$user->id])->first();
          //  dd($hasChat);
        if($hasChat){
            return response()->json([ 'msg'=>'success' , 'data' => [
                'roomId' => $hasChat->id, 
                
                ] ]);
        }else{
            return response()->json([ 'msg'=>'success' , 'data' => 'لا يوجد غرفه محادثه مسبقة استدعي لنك addMessage' ]);
        }
    }
    public function myChats(Request $request)
    {
        $arr = array();
        $user = auth()->guard('api')->user();
        $chats= ChatMessage::where('from_id', $user->id)->orWhere('to_id',$user->id)->orderBy('created_at','asc')->paginate(5);
        foreach($chats as $chat){
            $sender = User::where('id', $chat->to_id)->first();
            $received = User::where('id', $chat->from_id)->first();
            $followingCount = Follow::where('user_id',$received->id)->get()->count(); 
            $followerCount = Follow::where('following_id',$received->id)->get()->count();
            array_push($arr, array(
                'chat' => $chat,
                'user' => $received,
                'followingCount' =>$followingCount,
                'followerCount' =>$followerCount,
            ));
        }
      return response()->json([ 'msg'=>'success' , 'data' => $arr]);
    }
    public function searchChatName(Request $request)
    {
         $arr = array();
         $user = auth()->guard('api')->user();
         $chats= ChatMessage::where('from_id', $user->id)->orWhere('to_id',$user->id)->get();
        foreach($chats as $chat){
            $usersData = User::where(['id'=> $chat->user_id ])->orWhere('id', $chat->from_id)->where('name','like','%'.$request['name'].'%')->paginate(5);
                array_push($arr, array(
                    "usersData"=>$usersData,
                    ));
       }
        return response()->json(['msg'=>'success','data' => $arr]);
      
    }
}
