@extends('dashboard.index')
@section('styles')
<style>
.card-body {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  min-height: 1px;
  padding: 1.25rem;
}
/* width */
::-webkit-scrollbar {
    width: 7px;
  }
  
  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f100; 
  }
   
  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #f1f1f1; 
  }
  
  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #8080807a; 
  }
   #outerDiv {
    width: 40em;
    margin: 0em;
 }
 #scrollableContent {
    width: 100%;
    margin: 0em;
 }
</style>
@endsection
@section('content')
    <h2> مزودين الخدمه</h2>
    <div class="col-sm-6" >
    
            <div style="width:100%;">
            <div class="card-body table-responsive p-0" >
            <div id="outerDiv">
            <div id="scrollableContent">
              <table class="table table-hover text-nowrap"  >
        
            <thead>
            <tr>
                <th >الرقم</th>
                <th >اسم  مزود الخدمه</th>
                <th ">رقم مزود  الخدمه</th>
                <th >الخدمه  الرئسيه</th>
                <th >الخدمه الفرعيه</th>
                <th > العنوان </th>
                <th > صور الخدمه </th>
                <th > رقم اللوحه </th>
                <th > صوره الهويه </th>
                <th > صوره الرخصه </th>
                <th > صورة المركبه من الامام </th>
                <th > صورة المركبه من الخلف </th>
                <th >الإتاحه</th>
                <th >الحدث</th>
            </tr>
            </thead>
           
            @if(count($services) > 0)
                @foreach($services as $service)
                <?php
                    $categoryName = DB::table('categories')->where('id',$service->category_id)->value('name');
                    $subCategoryName = DB::table('sub_categories')->where('id',$service->subCategory_id)->value('name');
                    $images = DB::table('images')->where('service_id',$service->id)->get();
                    //dd($images);
                ?>
                    <tbody>
                    <tr>
                        <td >{{$loop->index +1 }}</td>
                        <td >{{$service->user->name}}</td>
                        <td >{{$service->user->phone}}</td>
                        <td >{{$categoryName}}</td>
                       
                        <td >{{$subCategoryName}}</td>
                   
                        <td >{{$service->address}}</td>
                       
                        <td >
                         @foreach($images as $image)
                        <img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/images/' .$image->image) }}">
                    @endforeach
                </td>
                        <td >{{$service->PlateNumber}}</td>
                        <td ><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/services/' .$service->imageId) }}"></td>
                        <td ><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/services/' .$service->Imagelicense) }}"></td>
                        <td ><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/services/' .$service->ImageFrontCar) }}"></td>
                        <td ><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/services/' .$service->ImageBackCar) }}"></td>
                        <td >
                            
                            <form action="{{route('available.update',$service->id)}}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_available" >
                                    <button type="submit" class="btn btn-default">
                                    @if ($service->is_available == 0 )
                                    <i style="color:crimson" class="fa fa-lock" aria-hidden="true"></i> 
                                    @elseif ($service->is_available == 1)
                                    <i style="color:#1FAB89" class="fa fa-unlock" aria-hidden="true"></i> 
                                    @endif
                                    </button>
                                </form>
                            
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
 </div>
 </div>
 </div>
     </div>      
        {{ $services->links() }}

    </div>

@endsection