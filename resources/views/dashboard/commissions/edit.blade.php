@extends('dashboard.index')
@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2>
         تفاصيل التحويل 
      </h2>
      
    </section>
    <section class="content">
            <div class="box box-primary">

               @include('includes.messages')
              <form role="form"
               action="{{route('commissions.update',$commission->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
             <?php 
             $userName = DB::table('users')->where('id',$commission->user_id)->value('name');
             $service = DB::table('services')->where('id',$commission->service_id)->first();
             $category = DB::table('categories')->where('id',$service->category_id)->value('name');
             $sub_category = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
             
             ?>
             <div class="form-group">
                <label style="font-size: 20px;" for="nameAccount">اسم  المستخدم </label>
                <input type="text" name="nameAccount"
                       placeholder="ادخل  اسم  المستخدم "
                       class="form-control" value="{{$userName}}">
            </div>
            <div class="form-group">
                <label style="font-size: 20px;" for="nameAccount">اسم الخدمة الرئيسيه </label>
                <input type="text" name="nameAccount"
                       placeholder="ادخل  اسم  الصنف "
                       class="form-control" value="{{$category}}">
            </div>
            <div class="form-group">
                <label style="font-size: 20px;" for="nameAccount">اسم  الخدمة الفرعية </label>
                <input type="text" name="nameAccount"
                       placeholder="ادخل  اسم  الصنف "
                       class="form-control" value="{{$sub_category}}">
            </div>
           
            
            <div class="form-group">
                <label style="font-size: 20px;" for="beneficiary">سعر العموله </label>
                <input type="text" name="beneficiary"
                       placeholder="سعر العمولة "
                       class="form-control" value="{{$commission->amountMony}}">
            </div>
            <div  class="form-group image" >
                  <label style="font-size: 20px;" for="image">صورة الاصال</label>
                  <br>
                  <img src="{{ asset('public/pictures/commissions/' . $commission->imageRecepit) }}">
                </div>
                <div class="box-footer">
                <a type="button" class="btn btn-warning" href="{{ route('commissions.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            </div>
            </div>
              </div> 
            </form>
    @endsection