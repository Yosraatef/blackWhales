<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\User;
class UserController extends Controller
{
    
    // admin login and logout
   public function showLogin(){
   
        return view('dashboard.login');
    }

    public function login(Request $request){

        $rules = [
            'email'     => 'required|email',
            'password'  => 'required|min:6'

            ];
        $this->validate($request , $rules);
        $credentials = $request->only('email','password');
        if(! Auth::guard('admin')->attempt($credentials)){
            return back()->withErrors([
                'message' => 'Wrong credentials please try Again '
            ]);

        }
        Session::flash('message' , 'تم تسجيل الدخول بشكل ناجح');
        return redirect()->route('adminPanal');

    }

    public function logout(){
        Auth::guard('admin')->logout();
        Session::flash('message','تم  تسجيل الخروج بنجاح ');
        return redirect()->route('admin.showLogin');
    }

    // user in dashboard
    public function index()
    {
        $users = User::paginate(15);
        
         return view('dashboard.users.show',compact('users'));
    }

    public function create()
    {
       return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'     => 'string|max:120',
            'phone'     => 'required|numeric|unique:users',
            'password' => 'required|min:6',
            ];

        $this->validate($request , $rules);
        $user = new User;
        $user->name  = $request->name;
        $user->phone  = $request->phone;
        $user->email  = $request->email;
        $user->type  =0;
        $user->password   = bcrypt($request->password);
        $user->api_token = Str::random(60);
        if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/users'), $filename);
            $user->image = $filename;
        }
        $user->save();
        //Session
        Session::flash('message' , 'تم تسجيل الدخول بشكل ناجح');
        //redirect
        return redirect()->route('users.index');
    }
    public function edit($id)
    {
        $user = User::where('id',$id)->first();
        return view('dashboard.users.edit',compact('user'));
    }
    public function update(Request $request, $id)
    {
       $user = User::findOrFail($id);
        $rules = [
            'name'     => 'string|max:120',
            'phone'     => 'required|numeric',
        ];
        $this->validate($request ,$rules );
        $input = $request->all();
        if($request->has('password') && $user->password != $request->password){
            $input['password'] = bcrypt($request->password);
        }
        $user->name  = $request->name;
        $user->phone  = $request->phone;
        $user->email  = $request->email;
        $user->password   = bcrypt($request->password);
         if ($request->hasFile('imageProfile')) {
            $filename = time() . '-' . $request->imageProfile->getClientOriginalName();
            $request->imageProfile->move(public_path('pictures/users'), $filename);
            $user->imageProfile = $filename;
        }
       
        $user->save();

        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('users.index');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
