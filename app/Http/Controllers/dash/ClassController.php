<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;
use App\Category;
use App\SubCategory;
use App\Brand;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class ClassController extends Controller
{
  
    public function index()
    {
        $classes = Section::paginate(15);
         return view('dashboard.classes.show',compact('classes'));
    }
    public function create()
    {
       $categories = Category::all();
       $subCategories = SubCategory::all();
       $brands = SubCategory::all();
       return view('dashboard.classes.create',compact('categories','subCategories','brands'));
    }
     public function getSubCategories($id)
    {  
        
        $test=0;
        $category= Category::find($id);
      // dd($category);
        $subCategories = SubCategory::where('category_id', $id)->get();
        //dd($subCategories);
        return json_encode(['data1'=>$subCategories,'test'=>$test]);
    }
     public function getBrands($id)
    {  
       
        $test=0;
        $subCategories= SubCategory::find($id);
        $brands = Brand::where('subCategory_id', $id)->get();
        return json_encode(['data1'=>$brands,'test'=>$test]);
    }
    public function store(Request $request)
    {
        $rules = 
           [
            'name'     => 'required',
            ];

        $this->validate($request , $rules);
        $data = $request->all();
        $subCategories = Section::create($data);
        Session::flash('message' , 'تم  اضافة  الخدمة بنجاح ');
        //redirect
        return redirect()->route('classes.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $class = Section::where('id',$id)->first();
         //dd($detailsSubCategory);
         $brands = Brand::where('id', $class->brand_id)->get();
         foreach ($brands as $brand) {
           $subCategories = SubCategory::where('id', $brand->subCategory_id)->get();
             foreach ($subCategories as $cat) {
                $categories = Category::where('id', $cat->category_id)->get();
              }
         }
         
         //dd($categories);
        return view('dashboard.classes.edit',compact('class','brands','subCategories','categories'));
    }
    public function update(Request $request, $id)
    {
        $rules = [
           'name'     => 'required|string|max:120',
        ];
        $this->validate($request ,$rules );
        $class = Section::findOrFail($id);
        $data = $request->except('image');
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/classes'), $filename);
            $data['image'] = $filename;
        }
        $class->update($data);
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('classes.index');
    }

    public function destroy($id)
    {
        $class = Section::findOrFail($id);

        $class->delete();
        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
