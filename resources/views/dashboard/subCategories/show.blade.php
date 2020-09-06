@extends('dashboard.index')
@section('content')
    <h3> الأقسام  الفرعية</h3>
    <div class="col-md-12 col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>القسم  الرئسية</th>
                <th>اسم  القسم الفرعي</th>
                <th>صورة </th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($subCategories) > 0)
                @foreach($subCategories as $subCategory)
                   
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$subCategory->category->name}}</td>
                        <td>{{$subCategory->name}}</td>
                        @if(!is_null($subCategory->image))
                        <td><img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/subCategories/' .$subCategory->image) }}"></td>
                            @else
                            <td></td>
                            @endif
                        <td><a href="{{route('subCategories.edit', $subCategory->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('subCategories.destroy',$subCategory->id)}}" method="POST">
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

        {{ $subCategories->links() }}

    </div>

@endsection