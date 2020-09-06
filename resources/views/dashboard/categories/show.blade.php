@extends('dashboard.index')
@section('content')
    <h2> الأقسام الرئسية</h2>
    <div class="col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th> الاسم </th>
                <th> الصورة</th>
                <th>سعر الاعلان العادي</th>
                <th> سعر الاعلان المميز</th>
                <th> سعر الاعلان الvip</th>
                <th>عدد ايام الاعلان العادي</th>
                <th>عدد ايام الاعلان المميز</th>
                <th>عدد ايام الاعلان الvip   </th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($categories) > 0)
                @foreach($categories as $category)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$category->name}}</td>
                        @if(!is_null($category->image))
                        <td><img style="hight:120px;width:120px;margin:5px;" 
                            src="{{ asset('pictures/categories/' . $category->image) }}"></td>
                        @else
                            <td></td>
                        @endif
                        <td>{{$category->normalPrice}} ريال</td>
                        <td>{{$category->specialPrice}} ريال</td>
                        <td>{{$category->vipPrice}} ريال</td>
                        <td>{{$category->normalDays}} يوم</td>
                        <td>{{$category->specialDays}} يوم</td>
                        <td>{{$category->vipDays}} يوم</td>
                        <td><a href="{{route('categories.edit', $category->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>

                        <td>

                            <form action="{{route('categories.destroy',$category->id)}}" method="POST">
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

        {{ $categories->links() }}

    </div>

@endsection