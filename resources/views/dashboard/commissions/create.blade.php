@extends('dashboard.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>تنبية العميل لدفع العمولة<h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('commissions.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

             

              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">

            <div class="form-group">
                <label style="font-size: 20px;" for="user_id">المستخدمين </label>
                <select id="myList" class="form-control" name="user_id" >
                     <option>اختر  العميل   </option>
                  @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                  @endforeach
                </select>
              </div>
            <div class="form-group">
                <label style="font-size: 20px;" for="price"> القيمة </label>
                <input type="text" name="price"
                       placeholder="ادخل القيمة "
                       class="form-control">
            </div>
            
               
              

                <div class="box-footer">
                <button type="submit" class="btn btn-primary">ارسال</button>
                
              </div>
                </div>
                
              
            
              </div> 
            </form>
    @endsection