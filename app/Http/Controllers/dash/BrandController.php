<?php

namespace App\Http\Controllers\dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Category;
use App\SubCategory;
use App\Brand;
class BrandController extends Controller
{
  
    public function index()
    {
         $brands = Brand::paginate(15);
        //dd($detailsSubCategories);
         return view('dashboard.detailsSubCategories.show',compact('brands'));
    }
    public function create()
    {
       $categories = Category::all();
       $subCategories = SubCategory::all();
       return view('dashboard.detailsSubCategories.create',compact('categories','subCategories'));
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
    public function store(Request $request)
    {
        
        $rules = 
           [
            'name'     => 'required',
            ];

        $this->validate($request , $rules);
        $data = $request->except('image');
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/brands'), $filename);
            $data['image'] = $filename;
        }
        
        $subCategories = Brand::create($data);
        Session::flash('message' , 'تم  اضافة  الخدمة بنجاح ');
        //redirect
        return redirect()->route('detailsSubCategories.index');
    }

 
    public function edit($id)
    {
         $detailsSubCategory = Brand::where('id',$id)->first();
         //dd($detailsSubCategory);
         $subCat = SubCategory::where('id', $detailsSubCategory->subCategory_id)->get();
         foreach ($subCat as $cat) {
           $categories = Category::where('id', $cat->category_id)->get();
           dd($categories);
         }
         
         //dd($categories);
        return view('dashboard.detailsSubCategories.edit',compact('detailsSubCategory','categories','subCat'));
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
        $Category = Brand::findOrFail($id);
        // $rules = [
        //    'name'     => 'required|string|max:120',
        // ];
        // $this->validate($request ,$rules );
        $data = $request->except('image');
         if ($request->hasFile('image')) {
            $filename = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('pictures/brands'), $filename);
            $data['image'] = $filename;
        }
        $Category->update($data);
        Session::put('message','تم التعديل بشكل ناجح ');
        //redirect
        return redirect()->route('detailsSubCategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = Brand::findOrFail($id);

        $Category->delete();

        Session::flash('message','تم  المسح بنجاح');

        return redirect()->back();
    }
}
