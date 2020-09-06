@extends('dashboard.index')
@section('content')
    <h3>الفئات</h3>
    <div style="overflow-x:auto;" class="col-md-12 col-sm-6 text-nowrap ">

        <table class="table-wrapper-scroll-x my-custom-scrollbar table ">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>اسم صاحب الاعلان</th>
                <th>رقم  التلفون</th>
                <th>القسم الرئسية</th>
                <th>القسم  الفرعي </th>
                <th> الماركة </th>
                <th> الفئة</th>
                <th>صورة الاعلان الرئسيه</th>
                <th>رقم  الإعلان</th>
                <th>اسم الاعلان</th>
                <th>وصف   الاعلان</th
               <td>السعر</td>
               <td>قبول الاعلان</td>
                <th>الحدث</th>
            </tr>
            </thead>
       

            @if(count($advertisement) > 0)
                @foreach($advertisement as $advertising)
                <?php
                $catName = DB::table('categories')->where('id', $advertising->category_id)->value('name');
                $subcatName = DB::table('sub_categories')->where('id', $advertising->subCategory_id)->value('name');
                $brandName = DB::table('brands')->where('id', $advertising->brand_id)->value('name');
                $className = DB::table('classes')->where('id', $advertising->class_id)->value('name');

                ?>
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$advertising->user->name}}</td>
                        <td>{{$advertising->user->phone}}</td>
                        <td>{{$catName}}</td>
                        <td>{{$subcatName}}</td>
                        <td>{{$brandName}}</td>
                        <td>{{$className}}</td>
                        
                        <td><img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/advertisement/' . $advertising->image) }}"></td>
                       <td>{{$advertising->code_number }}</td>
                       <td>{{$advertising->title }}</td>
                       <td>{{$advertising->description }}</td>
                       <td>
                            <form action="{{route('available.update',$advertising->id)}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_available" >
                                    <button type="submit" class="btn btn-default">
                                    @if ($advertising->is_acceptance == 0 )
                                    <i style="color:crimson" class="fa fa-lock" aria-hidden="true"></i> 
                                    @elseif ($advertising->is_acceptance == 1)
                                    <i style="color:#1FAB89" class="fa fa-unlock" aria-hidden="true"></i> 
                                    @endif
                                    </button>
                                </form>
                       </td>
                        <td>

                            <form action="{{route('advertising.destroy',$advertising->id)}}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button class="btn btn-outline-danger">احذف</button>

                            </form> 
                        </td>

                    </tr>
                    </tbody>
                @endforeach
            @endif
        </table>

        

    </div>

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