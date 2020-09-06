<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Setting;
class SettingController extends Controller
{
    private $keys = array("WarningText","conditions","who");
    public function index()
    {
        $settings = Setting::all();
        return view('dashboard.settings.index',compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::whereIn('key',$this->keys)->get(["key","value"]);
        $settings_data=array();
        foreach ($settings as $item){
            $settings_data[$item->key]=$item->value;
        }
        return view('dashboard.settings.create',compact('settings_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($this->keys as $key) {
            // dd($key);
            if($request->has($key) && !is_null($request->$key)){
              Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->$key]
                );  
            } 
            }

        Session::flash('message','تم انشاء اعدادت جديدة');
        return redirect()->route('settings.create');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
