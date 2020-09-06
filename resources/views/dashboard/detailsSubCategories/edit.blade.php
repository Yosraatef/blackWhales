@extends('dashboard.index')
@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>
         تعديل  الماركة
      </h3>
      
    </section>
    <section class="content">
            <div class="box box-primary">

               @include('includes.messages')
              <form role="form"
               action="{{route('detailsSubCategories.update',$detailsSubCategory->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                   <div id="category_id" class="form-group " >
                <label for="category_id">القسم الرئسي</label>
                <select id="category" onchange="showSubCategories(this)" class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="category_id">
                  <option value="">اختر القسم المناسب</option>
                  @foreach($categories as $category)
                    <option value="{{$category->id}}" >{{ $category->name}}</option>
                  @endforeach
                </select>
              </div>
               <div class="form-group sub_category">
                  <label for="subCategory_id">القسم الفرعي </label>
                 <select  name="subCategory_id" id="catstyle_sect" class="form-control">
                    
                  </select>
                </div>
                <div  id="select_others" class="form-group">
                <label for="name">اسم  الماركة  </label>
                <input type="text" name="name"
                       placeholder="ادخل  اسم  الخدمة "
                       class="form-control" value="{{$detailsSubCategory->name}}">
                </div>
                <div id="select_other" class="form-group image" >
                      <label for="image">صورة  اللوجو </label>
                      <br>
                  <input type="file" name="image" id="image">
                
             <img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/brands/' .$detailsSubCategory->image) }}">
                </div>  
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a type="button" class="btn btn-warning" href="{{ route('detailsSubCategories.index') }}">الرجوع</a>
              </div>
                </div>
                
              
            </div>
            </div>
              </div> 
            </form>
    @endsection
      @section('scripts')
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

    <script>
      
 
        function showSubCategories(sel) {
            
            var id = sel.value;
            //alert(id);
            $.ajax({

                url : '/dashboard/getSubcategories/'+id,
                type:'GET',
                dataType: 'json',
                success: function(data) {

                   var len = data.data1.length;
                    $("#catstyle_sect").empty();
                    for( var i = 0; i<len; i++){
                        var id = data.data1[i]['id'];
                        var name = data.data1[i]['name'];

                        $("#catstyle_sect").append("<option value='"+id+"'>"+name+"</option>");

                    }

                  }
                });
    }
        
    </script>
   <!--  -->
    @endsection