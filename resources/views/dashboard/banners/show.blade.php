@extends('dashboard.index')
@section('content')
    <h2> المساحات  الاعلانية</h2>
    <div class="col-md-12 col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th> الاسم </th>
                <th> الصورة</th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($banners) > 0)
                @foreach($banners as $banner)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$banner->text}}</td>
                        @if(!is_null($banner->image))
                        <td><img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/banners/' . $banner->image) }}"></td>
                        @else
                            <td></td>
                        @endif                        
                        <td><a href="{{route('banners.edit', $banner->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>

                        <td>

                            <form action="{{route('banners.destroy',$banner->id)}}" method="POST">
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

        {{ $banners->links() }}

    </div>

@endsection