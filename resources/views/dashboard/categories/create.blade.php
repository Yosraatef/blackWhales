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
              <form role="form" action="{{route('categories.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

              <div class="box-body">
                <div class="col-lg-offset-3  col-md-6">
                  <div class="form-group">
                      <label for="name">اسم  القسم</label>
                      <input type="text" name="name"
                             placeholder="ادخل  اسم  القسم "
                             class="form-control">
                  </div> 
                   <div id="select_other" class="form-group image" >
                      <label for="image">صورة  </label>
                      <br>
                  <input type="file" name="image" id="image">
                </div>
                <div class="form-group" >
                      <label for="normalPrice">سعر الاعلان العادي</label>
                      <input type="text" name="normalPrice" min="0" 
                             placeholder="ادخل سعر الاعلان العادي"
                             class="form-control">
                  </div> 
                  <div class="form-group">
                      <label for="specialPrice">سعر الاعلان المميز </label>
                      <input type="text" name="specialPrice" min="0" 
                             placeholder=" ادخل سعر الاعلان المميز"
                             class="form-control">
                  </div> 
                  <div class="form-group">
                      <label for="vipPrice">سعر الاعلان الvip</label>
                      <input type="text" name="vipPrice" min="0" 
                             placeholder="  vipسعر  ال "
                             class="form-control">
                  </div> 
                  <div class="form-group">
                      <label for="normalDays">عدد ايام بقاء الاعلان العادي</label>
                      <input type="text" name="normalDays" min="1" 
                             placeholder="ادخل عدد الايام "
                             class="form-control">
                  </div> 
                  <div class="form-group " >
                      <label for="specialDays">عدد ايام بقاء الاعلان المميز</label>
                      <input type="text" name="specialDays" min="1" 
                             placeholder=" ادخل عدد ايام بقاء الاعلان المميز "
                             class="form-control">
                  </div> 
                  <div class="form-group">
                      <label for="vipDays">عدد ايام بقاء الاعلان الvip</label>
                      <input type="text" name="vipDays" min="1" 
                             placeholder="ادخل عدد الايام  "
                             class="form-control">
                  </div> 
                <div style="margin:5px;" class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('categories.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection