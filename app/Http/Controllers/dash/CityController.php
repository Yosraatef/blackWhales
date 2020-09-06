<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\City;
use App\Country;
class CityController extends Controller
{
    
    public function index()
    {
         $cities = City::paginate(15);
         return view('dashboard.cities.show',compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $countries = Country::all();
       return view('dashboard.cities.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $rules = 
           [
            'name'     => 'required',
            ];

        $this->validate($request , $rules);
         $data = $request->all();
        $city = City::create($data);
        Session::flash('message' , 'تم  اضافة   بنجاح ');
        //redirect
        return redirect()->route('city.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
         $city = City::where('id',$id)->first();
         $countries = Country::all();
        return view('dashboard.cities.edit',compact('city','countries'));
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
        $subCategory = City::findOrFail($id);
        $data = $request->all();
        $subCategory->update($data);
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('city.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);

        $city->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
