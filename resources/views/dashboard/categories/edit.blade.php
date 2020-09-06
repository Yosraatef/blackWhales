@extends('dashboard.index')
@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2>
         تعديل  اسم  الصنف
      </h2>
      
    </section>
    <section class="content">
            <div class="box box-primary">

               @include('includes.messages')
              <form role="form"
               action="{{route('categories.update',$category->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
             
                  <div class="form-group">
                      <label for="name">الاسم</label>
                      <input type="text" name="name"
                             placeholder="ادخل  الاسم "
                             class="form-control" value="{{$category->name}}">
                  </div>
                 <div id="select_other" class="form-group image" >
                      <label for="image">صورة  </label>
                      <br>
                  <input type="file" name="image" id="image">
                </div>   
                <img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/categories/' . $category->image) }}">
                 <div class="form-group" >
                      <label for="normalPrice">سعر الاعلان العادي</label>
                      <input type="text" name="normalPrice" min="0" 
                             placeholder="ادخل سعر الاعلان العادي"
                             class="form-control" 
                             value="{{$category->normalPrice}}">
                  </div> 
                  <div class="form-group">
                      <label for="specialPrice">سعر الاعلان المميز </label>
                      <input type="text" name="specialPrice" min="0" 
                             placeholder=" ادخل سعر الاعلان المميز"
                             class="form-control" 
                             value="{{$category->specialPrice}}">
                  </div> 
                  <div class="form-group">
                      <label for="vipPrice">سعر الاعلان الvip</label>
                      <input type="text" name="vipPrice" min="0" 
                             placeholder="  vipسعر  ال "
                             class="form-control" 
                             value="{{$category->vipPrice}}">
                  </div> 
                  <div class="form-group">
                      <label for="normalDays">عدد ايام بقاء الاعلان العادي</label>
                      <input type="text" name="normalDays" min="1" 
                             placeholder="ادخل عدد الايام "
                             class="form-control" 
                             value="{{$category->normalDays}}">
                  </div> 
                  <div class="form-group " >
                      <label for="specialDays">عدد ايام بقاء الاعلان المميز</label>
                      <input type="text" name="specialDays" min="1" 
                             placeholder=" ادخل عدد ايام بقاء الاعلان المميز "
                             class="form-control" 
                             value="{{$category->specialDays}}">
                  </div> 
                  <div class="form-group">
                      <label for="vipDays">عدد ايام بقاء الاعلان الvip</label>
                      <input type="text" name="vipDays" min="1" 
                             placeholder="ادخل عدد الايام  "
                             class="form-control"
                             value="{{$category->vipDays}}">
                  </div> 
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a type="button" class="btn btn-warning" href="{{ route('categories.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            </div>
            </div>
              </div> 
            </form>
    @endsection