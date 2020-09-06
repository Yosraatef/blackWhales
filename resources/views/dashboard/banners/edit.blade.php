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
               action="{{route('banners.update',$banner->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
             
                  <div class="form-group">
                      <label for="name">الاسم</label>
                      <input type="text" name="text"
                             placeholder="ادخل  الاسم "
                             class="form-control" value="{{$banner->text}}">
                  </div>
                 <div id="select_other" class="form-group image" >
                      <label for="image">صورة  </label>
                      <br>
                  <input type="file" name="image" id="image">
                </div>   
                <img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/banners/' . $banner->image) }}">
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a type="button" class="btn btn-warning" href="{{ route('banners.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            </div>
            </div>
              </div> 
            </form>
    @endsection