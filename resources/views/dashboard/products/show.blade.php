@extends('dashboard.index')
@section('content')
    <h2> مزودين الخدمه</h2>
    <div class="col-sm-6">

         <table class="table">
            <thead>
            <tr>
                <th >الرقم</th>
                <th>اسم  مزود الخدمه</th>
                <th>رقم مزود  الخدمه</th>
                <th>الخدمه  الرئسيه</th>
                <th>الخدمه الفرعيه</th>
                <th> العنوان </th>
                <th> صور الخدمه </th>
                <th> رقم اللوحه </th>
                <th> صوره الهويه </th>
                <th> صوره الرخصه </th>
                <th> صورة المركبه من الامام </th>
                <th> صورة المركبه من الخلف </th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($services) > 0)
                @foreach($services as $service)
                <?php
                    $categoryName = DB::table('categories')->where('id',$service->category_id)->value('name');
                    $subCategoryName = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
                    $subCategoryBus = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('size_bus');
                    $subCategoryClean = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('size_clean');
                    $subCategorySurfaces = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('size_surfaces');
                    $images = DB::table('images')->where('service_id',$service->id)->get();
                    //dd($images);
                ?>
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$service->user->name}}</td>
                        <td>{{$service->user->phone}}</td>
                        <td>{{$categoryName}}</td>
                        @if(is_null($subCategoryName))
                            @if(is_null($subCategoryBus))
                                @if(is_null($subCategoryClean))
                                    @if(is_null($subCategorySurfaces))
                                        <td> </td>
                                    @else
                                        @if($subCategorySurfaces == 1)
                                        <td>كبيرة</td>
                                        @elseif($subCategorySurfaces == 2)
                                        <td>صغيرة</td>
                                        @endif
                                    @endif
                                @else
                                    @if($subCategoryClean == 1)
                                    <td>كبيرة </td>
                                    @elseif($subCategoryClean == 2)
                                    <td>متوسظه</td>
                                    @elseif($subCategoryClean == 3)
                                    <td>صغيره</td>
                                    @endif
                                @endif
                            @else
                                @if($subCategoryBus == 1)
                                <td>باص 45-55</td>
                                @elseif($subCategoryBus == 2)
                                <td>باص   صغير</td>
                                @endif
                            @endif
                        @else
                        <td>{{$subCategoryName}}</td>
                        @endif
                        
                        <td>{{$service->address}}</td>
                       
                        <td>
                         @foreach($images as $image)
                        <img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/images/' .$image->image) }}">
                    @endforeach
                </td>
                        <td>{{$service->PlateNumber}}</td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/services/' .$service->imageId) }}"></td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/services/' .$service->Imagelicense) }}"></td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/services/' .$service->ImageFrontCar) }}"></td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/services/' .$service->ImageBackCar) }}"></td>
                        <td><a href="{{route('services.edit', $service->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('services.destroy',$service->id)}}" method="POST">
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
 

        {{ $services->links() }}

    </div>

@endsection
@section('scripts')
    <script>
       $(document).ready(function(){

            jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');
        });
    </script>
    @endsection