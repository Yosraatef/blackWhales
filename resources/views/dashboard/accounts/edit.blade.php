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
               action="{{route('accounts.update',$account->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
             
                  <div class="form-group">
                <label for="nameAccount">اسم  البنك </label>
                <input type="text" name="nameAccount"
                       placeholder="ادخل  اسم  البنك "
                       class="form-control" value="{{$account->nameAccount}}">
            </div>
            <div class="form-group">
                <label for="numberAccount">رقم  الحساب </label>
                <input type="text" name="numberAccount"
                       placeholder="ادخل  رقم  الحساب "
                       class="form-control" value="{{$account->numberAccount}}">
            </div>
            <div class="form-group">
                <label for="appearance"> الإبيان </label>
                <input type="text" name="appearance"
                       placeholder="ادخل الإبيان "
                       class="form-control" value="{{$account->appearance}}">
            </div>
            <div class="form-group">
                <label for="beneficiary">اسم المستفيد </label>
                <input type="text" name="beneficiary"
                       placeholder="ادخل اسم المستفيد "
                       class="form-control" value="{{$account->beneficiary}}">
            </div>
            <div  class="form-group image" >
                  <label for="image">صورة المصرف</label>
                  <br>
                  <input type="file" name="image" id="image">
                  <img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/accounts/' . $account->image) }}">
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