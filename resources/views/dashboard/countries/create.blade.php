@extends('dashboard.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
        اضافة   دولة </h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('country.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                  <div class="form-group">
                      <label for="name">اسم  الدولة</label>
                      <input type="text" name="name"
                             placeholder="ادخل  اسم  الدولة "
                             class="form-control">
                  </div> 
                 
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('country.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection