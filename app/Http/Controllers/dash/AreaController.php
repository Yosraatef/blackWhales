<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\City;
use App\Area;
use App\Country;
class AreaController extends Controller
{
    
    public function index()
    {
        $areas = Area::paginate(15);
         return view('dashboard.areas.show',compact('areas'));
    }
    public function create()
    {
       $countries = Country::all();
       $cties = City::all();
       return view('dashboard.areas.create',compact('cties','countries'));
    }
    public function getCities($id)
    {  
        $country= Country::find($id);
        //dd($country->id);
        $cities = City::where('country_id', $id)->get();
        //dd($cities);
        return json_encode(['data1'=>$cities]);
    }
    public function store(Request $request)
    {
          $rules = 
           [
            'name'     => 'required',
            ];

        $this->validate($request , $rules);
         $data = $request->all();
        $area = Area::create($data);
        Session::flash('message' , 'تم  اضافة   بنجاح ');
        //redirect
        return redirect()->route('area.index');
    }
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $area = Area::where('id',$id)->first();
         $countries = Country::all();
       $cities = City::all();
        return view('dashboard.areas.edit',compact('area','cities','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
           'name'     => 'required|string|max:120',
        ];
        $this->validate($request ,$rules );
        $area = Area::findOrFail($id);
        $data = $request->all();
        $area->update($data);
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('area.index');
    }

    public function destroy($id)
    {
         $area = Area::findOrFail($id);

        $area->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
