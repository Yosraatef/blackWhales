@extends('dashboard.index')
@section('content')
    <h3>الماركات</h3>
    <div class="col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>القسم الرئسية</th>
                <th>القسم  الفرعي </th>
                <th> الماركة </th>
                <th>اللوجو</th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
       

            @if(count($brands) > 0)
                @foreach($brands as $brand)
                  
                    <?php $subCategory = DB::table('sub_categories')->where('id', $brand->subCategory_id)->first(); 
                   $cat = DB::table('categories')->where('id', $subCategory->category_id)->first();
                    ?>
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$cat->name}}</td>
                        <td>{{$subCategory->name}}</td>
                        <td>{{$brand->name}}</td>
                        <td><img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/brands/' . $brand->image) }}"></td>
                        <td><a href="{{route('detailsSubCategories.edit', $brand->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('detailsSubCategories.destroy',$brand->id)}}" method="POST">
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