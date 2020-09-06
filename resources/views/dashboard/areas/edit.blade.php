@extends('dashboard.index')
@section('content')
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h2>
         تعديل  المنطقة
      </h2>
      
    </section>
    <section class="content">
            <div class="box box-primary">

               @include('includes.messages')
              <form role="form"
               action="{{route('area.update',$area->id)}}" method="post"
              enctype="multipart/form-data">
             {{ csrf_field()}}
             {{ method_field('PUT')}}
               <div class="box-body">
                <div class="col-lg-offset-3 col-md-6">
                  <div class="form-group">
                <label for="city_id"> الدولة  </label>
                <select id="myList" onchange="showCities(this)" class="form-control" name="city_id" >
                     <option>اختر  المدينة </option>
                  @foreach($countries as $country)
                    <option value="{{$country->id}}" >{{$country->name}}</option>
                  @endforeach
                </select>
              </div>

                  <div class="form-group">
                <label for="city_id"> المدينة </label>
                <select id="catstyle_sect"  class="form-control" name="city_id" >
                      @foreach($countries as $city)
                    <option value="{{$city->id}}" 
                      @if($area->city_id == $city->id)
                     selected
                     @endif>{{$city->name}}</option>
                     @endforeach
                  
                </select>
              </div>
              
                <div  id="select_others" class="form-group">
                <label for="name">المنطقة</label>
                <input type="text" name="name"
                       placeholder="ادخل  اسم  الخدمة "
                       class="form-control" value="{{$area->name}}">
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-primary">تعديل</button>
                <a type="button" class="btn btn-warning" href="{{ route('area.index') }}">الرجوع</a>
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
      
 
        function showCities(sel) {
            
            var id = sel.value;
            //alert(id);
            $.ajax({

                url : '/dashboard/getCities/'+id,
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