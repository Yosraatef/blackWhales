@extends('dashboard.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        اضافة  حساب  جديدة      </h1>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('accounts.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

             

              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">


            <div class="form-group">
                <label for="nameAccount">اسم  الحساب </label>
                <input type="text" name="nameAccount"
                       placeholder="ادخل  اسم  الحساب "
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="numberAccount">رقم  الحساب </label>
                <input type="text" name="numberAccount"
                       placeholder="ادخل  رقم  الحساب "
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="appearance"> الإبيان </label>
                <input type="text" name="appearance"
                       placeholder="ادخل الإبيان "
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="beneficiary">اسم المستفيد </label>
                <input type="text" name="beneficiary"
                       placeholder="ادخل اسم المستفيد "
                       class="form-control">
            </div>
            <div  class="form-group image" >
                  <label for="image">صورة المصرف</label>
                  <br>
                  <input type="file" name="image" id="image">
                </div>
               
              

                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('accounts.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection