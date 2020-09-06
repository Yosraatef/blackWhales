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
               action="{{route('city.update',$city->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                   <div class="form-group">
                <label for="country_id"> الصنف  </label>
                <select id="country_id" class="form-control" name="country_id">
                     <option>اختر الخدمة التابعه لها </option>
                  @foreach($countries as $country)
                    <option value="{{$country->id}}"
                      @if($city->country_id == $country->id)
                     selected
                  @endif>
                {{
                    $country->name}}</option>
                  @endforeach
                </select>
              </div>

            <div class="form-group">
                <label for="name">اسم  الخدمه الفرعية </label>
                <input type="text" name="name"
                       placeholder="ادخل  اسم  الخدمة "
                       class="form-control" value="{{$city->name}}">
            </div> 
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a type="button" class="btn btn-warning" href="{{ route('city.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            </div>
            </div>
              </div> 
            </form>
    @endsection