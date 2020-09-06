@extends('dashboard.index')
@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2>
         تعديل  اسم  الخدمة الفرعية
      </h2>
      
    </section>
    <section class="content">
            <div class="box box-primary">

               @include('includes.messages')
              <form role="form"
               action="{{route('subCategories.update',$subCategory->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                   <div class="form-group">
                <label for="category_id"> الصنف  </label>
                <select id="category_id" class="form-control" name="category_id">
                     <option>اختر الخدمة التابعه لها </option>
                  @foreach($categories as $category)
                    <option value="{{$category->id}}"
                      @if($subCategory->category_id == $category->id)
                     selected
                  @endif>
                {{
                    $category->name}}</option>
                  @endforeach
                </select>
              </div>

            <div class="form-group">
                <label for="name">اسم  الخدمه الفرعية </label>
                <input type="text" name="name"
                       placeholder="ادخل  اسم  الخدمة "
                       class="form-control" value="{{$subCategory->name}}">
            </div>
            <div  class="form-group image" >
                  <label for="image">صورة  الخدمة الفرعية</label>
                  <br>
                  <input type="file" name="image" id="image">
                  <img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/subCategories/' . $subCategory->image) }}">
                </div>
            
                  
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a type="button" class="btn btn-warning" href="{{ route('subCategories.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            </div>
            </div>
              </div> 
            </form>
    @endsection