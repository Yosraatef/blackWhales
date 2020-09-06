<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Advertising;
use DB;
class AdvertisingController extends Controller
{
   
    public function index()
    {
        $advertisement = Advertising::paginate(15);
         return view('dashboard.advertisement.show',compact('advertisement'));
    }

     public function acceptance(Request $request, $id)
    {
        $adv = Advertising::find($id);
      
              if($adv->is_acceptance == 0)
              {
                  
               $acceptAdv = DB::table('advertisement')->where('id',$id)->update(['is_acceptance' => 1]);
                 //Session
               Session::flash('message' , ' تم قبول الاعلان  ');
                return redirect()->back();
            }
            else 
              {

                 $acceptAdv = DB::table('advertisement')->where('id',$id)->update(['is_acceptance' => 0]);
               
                 Session::flash('message' , ' تم رفض الاعلان ');
                return redirect()->back();
              }
}
    public function create()
    {
        
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        $class = Advertising::findOrFail($id);

        $class->delete();
        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
