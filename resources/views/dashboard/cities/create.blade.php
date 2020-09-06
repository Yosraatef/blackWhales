@extends('dashboard.index')
@section('styles')
<style type="text/css">
  .items{
    display: none;
  }
</style>
@endsection
@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
        اضافة  مدينة</h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('city.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

           
              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                  <div class="form-group">
                <label for="country_id"> الدولة  </label>
                <select id="myList" class="form-control" name="country_id" >
                     <option>اختر الخدمة التابعه لها </option>
                  @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                  @endforeach
                </select>
              </div>
              
                <div  id="select_others" class="form-group">
                <label for="name">اسم  المدينة  </label>
                <input type="text" name="name"
                       placeholder="ادخل  اسم  الخدمة "
                       class="form-control">
                </div>
               
            
            </div>
            
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('categories.index') }}">الرجوع</a>
              </div>
                </div>

              </div> 
            </form>
    @endsection