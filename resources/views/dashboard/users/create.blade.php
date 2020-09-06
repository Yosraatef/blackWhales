@extends('dashboard.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
        اضافة مستخدم  جديد 
      </h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('users.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

             

              <div class="box-body">
                <div class="col-md-6">


            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" name="name"
                       placeholder="ادخل  الاسم "
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">رقم  الهاتف</label>
                <input type="text" name="phone"
                       placeholder="ادخل  رقم  الهاتف "
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="email">البريد الالكتروني</label>
                <input type="email" name="email"
                       placeholder="ادخل  البريد  الاألكتروني "
                       class="form-control">
            </div>
               <div class="form-group">
                <label for="password">الرقم السري</label>
                <input type="password" name="password"
                       placeholder="ادخل الرقم السري"
                       class="form-control">
            </div>
             
            <div  class="form-group image" >
                  <label for="image">الصورة  الشخصية</label>
                  <br>
                  <input type="file" name="image" id="image">
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('users.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection