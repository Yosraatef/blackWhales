@extends('dashboard.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         تعديل  المستخدم
      </h1>
      
    </section>
    <section class="content">
            <div class="box box-primary">

               @include('includes.messages')
              <form role="form"
               action="{{route('users.update',$user->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
             
                  <div class="form-group">
                      <label for="name">الاسم</label>
                      <input type="text" name="name"
                             placeholder="ادخل  الاسم "
                             class="form-control" value="{{$user->name}}">
                  </div>
                  <div class="form-group">
                      <label for="phone">رقم  الهاتف</label>
                      <input type="text" name="phone"
                             placeholder="ادخل  رقم  الهاتف "
                             class="form-control" value="{{$user->phone}}">
                  </div>
                   <div class="form-group">
                      <label for="email">رقم  الهاتف</label>
                      <input type="email" name="email"
                             placeholder="ادخل  البريد الالكتروني "
                             class="form-control" value="{{$user->email}}">
                  </div>
                    <div class="form-group">
                      <label for="password">الرقم السري</label>
                      <input type="password" name="password"
                             value="{{$user->password}}"
                             placeholder="ادخل الرقم السري"
                             class="form-control">
                  </div>

             <div  class="form-group image" >
                  <label for="imageProfile">الصورة  الشخصية</label>
                  <br>
                  <input type="file" name="imageProfile" id="imageProfile">
                  <img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/users/' . $user->image) }}">
                </div>
                 
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a type="button" class="btn btn-warning" href="{{ route('users.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            </div>
            </div>
              </div> 
            </form>
    @endsection