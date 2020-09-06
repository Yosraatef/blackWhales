<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Order;
use App\Product;
use App\User;
class DashboardController extends Controller
{
   
    public function index(){
        $users = User::where('type', 0)->count();
        $categories = Category::count();
        //$orders = Order::count();
        // $products = Product::count();
        return view('dashboard.dashboard',compact('categories','users'));
    }
    
    function fetch(Request $request)
    {
     $select = $request->get('select');
     $value = $request->get('value');
     $dependent = $request->get('dependent');
     $data = DB::table('main_categories')
       ->where($select, $value)
       ->groupBy($dependent)
       ->get();
     $output = '<option value="">Select '.ucfirst($dependent).'</option>';
     foreach($data as $row)
     {
      $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
     }
     echo $output;
    }
}
