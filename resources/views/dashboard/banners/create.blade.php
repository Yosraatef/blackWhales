@extends('dashboard.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
        اضافة  قسم  جديدة      </h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('banners.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                  <div class="form-group">
                      <label for="name">النص </label>
                      <input type="text" name="text"
                             placeholder="ادخل  النص "
                             class="form-control">
                  </div> 
                   <div id="select_other" class="form-group image" >
                      <label for="image">صورة  </label>
                      <br>
                  <input type="file" name="image" id="image">
                </div>   
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('banners.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection