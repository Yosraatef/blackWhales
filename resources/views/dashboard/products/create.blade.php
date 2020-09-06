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
            <div style="display:none" id="size_bus" class="items">
              <label for="size_bus"> النقل الجماعي  </label>
            <div class="form-group " >
                @foreach($subCategories as $subCategory)
                @if($subCategory->size_bus == 1)
                <input class="offer"   type="radio" value="{{$subCategory->id}}"  
                name="subCategory_id" >
                <label style="margin-left: 20px;" for="size_bus">باص 45 - 55</label>
                @endif
                @if($subCategory->size_bus == 2)
                <input   class="offer" type="radio" value="{{$subCategory->id}}" 
                name="subCategory_id">
               <label for="is_offer">باص   صغير </label>
               @endif
               @endforeach
                
            </div>

            </div>

            <div style="display:none" id="size_surfaces" class="items">
               <label for="size_surfaces"> الساطحات  </label>
              <div class="form-group " >
                  @foreach($subCategories as $subCategory)
                @if($subCategory->size_surfaces == 1)
                <input class="size_surfaces"   type="radio" value="{{$subCategory->id}}" name="subCategory_id">
                  <label style="margin-left: 20px;" for="size_surfaces"> كبيرة</label>
                @endif
                @if($subCategory->size_surfaces == 2)
                <input   class="offer" type="radio" value="{{$subCategory->id}}" name="subCategory_id">
                 <label for="size_surfaces">صغيرة </label>
               @endif
               @endforeach
              </div> 
            </div>
             
            <div style="display:none" id="size_clean" class="items">
                <label for="size_clean">  حاويات النظافة </label>
               <div class="form-group " >
                  @foreach($subCategories as $subCategory)
                  @if($subCategory->size_clean == 1)
                  <input class="size_clean"   type="radio" value="{{$subCategory->id}}" name="subCategory_id">
                  <label style="margin-left: 20px;" for="size_clean"> كبيرة</label>
                 @endif
                 @if($subCategory->size_clean == 2)
                  <input   class="offer" type="radio" value="{{$subCategory->id}}" name="subCategory_id">
                 <label for="size_clean" style="margin-left: 20px;"> متوسطة</label>
                 @endif
                 @if($subCategory->size_clean == 3)
                 <input   class="offer" type="radio" value="{{$subCategory->id}}" name="subCategory_id">
                 <label for="size_clean" > صغيرة</label>
                 @endif
               @endforeach
              </div>  
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
                <label for="PlateNumber">رقم لوحه التحكم</label>
                <input type="text" name="PlateNumber"
                       placeholder="ادخل  رقم لوحه التحكم "
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
                href="{{ route('categories.index') }}">الرجوع</a>
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