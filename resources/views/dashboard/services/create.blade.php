@extends('dashboard.index')

@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
        اضافة   مزود خدمة  جديد    </h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">
              
               @include('includes.messages')
              <form role="form" action="{{route('services.store')}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}

             

              <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                  <div class="form-group">
                <label for="user_id"> المستخدم   </label>
                <select class="form-control" name="user_id" >
                     <option>اختر  المستخدم التابعه لها </option>
                  @foreach($users as $user)
                    <option value="{{$user->id}}">
                     {{$user->phone}} 
                     
                   </option>
                  @endforeach
                </select>
              </div>
               <div class="form-group">
                <label for="category_id"> الصنف  </label>
                <select id="category" onchange="showSubCategories(this)" class="form-control" name="category_id" >
                     <option>اختر الخدمة التابعه لها </option>
                  @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </div>
               <div class="form-group sub_category">
                  <select  name="subCategory_id" id="catstyle_sect" class="form-control">
                    
                  </select>
                </div>
           
            @include('dashboard.partials.maps')
            <div class="form-group">
            <label style="margin-left: 20px;" for="images">اختر  صورة او اكتر لخدمتك</label>
            <div class="col-lg-10">
              <input type="file" name="images[]"  multiple="multiple">
               
            </div>
          </div>
            <div id="is_available" >
               <label for="size_surfaces">مزود الخدمه متاح ام  لا</label>
              <div class="form-group " >
                <input class="is_available"   type="radio" value="0" name="is_available">
                  <label style="margin-left: 20px;" for="is_available"> غير متاح  </label>

                <input   class="offer" type="radio" value="1" name="is_available">
                 <label for="is_available">متاح  خاليا</label>
              
              </div>
              <div class="form-group">
                <label for="PlateNumber">رقم لوحه المركبه</label>
                <input type="text" name="PlateNumber"
                       placeholder="ادخل  رقم لوحه المركبة "
                       class="form-control">
            </div> 
            <div class="form-group">
            <label style="margin-left: 20px;" for="imageId">صورة الهويه</label>
            <div class="col-lg-10">
              <input type="file" name="imageId"  >
            </div>
          </div>
              <div class="form-group">
            <label style="margin-left: 20px;" for="Imagelicense">صورة الرخصه</label>
            <div class="col-lg-10">
              <input type="file" name="Imagelicense"  >
            </div>
          </div>
          <div class="form-group">
            <label style="margin-left: 20px;" for="ImageFrontCar">صورة المركبة من الامام</label>
            <div class="col-lg-10">
              <input type="file" name="ImageFrontCar"  >
            </div>
          </div>
          <div class="form-group">
            <label style="margin-left: 20px;" for="ImageBackCar">صورة المركبة من الخلف</label>
            <div class="col-lg-10">
              <input type="file" name="ImageBackCar" >
            </div>
          </div>
            </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">اضافة</button>
                <a type="button" class="btn btn-warning" 
                href="{{ route('services.index') }}">الرجوع</a>
              </div>
                </div>
                
              <br>
            
              </div> 
            </form>
    @endsection
    @section('scripts')
    <script>
      // alert("Hello! I am an alert box!!");
 
        function showSubCategories(sel) {

            var id = sel.value;
            $.ajax({
                url : '/dashboard/getSubcategories/'+id,
                type:'GET',
                dataType: 'json',
                success: function(data) {
            //     alert(data.test);
if(data.test==1)
{

  //alert(data.test);

    $("#catstyle_sect").hide();
  $('.items').hide();
   $('#size_bus').show(); 
}
else if(data.test==2)
{

  //alert(data.test);

    $("#catstyle_sect").hide();
  $('.items').hide();
   $('#size_clean').show(); 
}
else if(data.test==3)
{

  //alert(data.test);

    $("#catstyle_sect").hide();
  $('.items').hide();
   $('#size_surfaces').show(); 
}
else{
 // alert(data.data1);
        $("#catstyle_sect").show();
        $('#size_bus').hide(); 
                    var len = data.data1.length;
                    $("#catstyle_sect").empty();
                    for( var i = 0; i<len; i++){
                        var id = data.data1[i]['id'];
                        var name = data.data1[i]['name'];

                        $("#catstyle_sect").append("<option value='"+id+"'>"+name+"</option>");

                    }

                }}

            });

        };
    
        
    </script>
    @endsection