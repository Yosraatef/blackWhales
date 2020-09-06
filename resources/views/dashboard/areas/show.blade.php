@extends('dashboard.index')
@section('content')
    <h3>المناطق</h3>
    <div class="col-md-12 col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>الدولة</th>
                <th>المدينة</th>
                <th>المنظقة </th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($areas) > 0)
                @foreach($areas as $area)
                   
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$area->city->country->name}}</td>
                        <td>{{$area->city->name}}</td>
                        <td>{{$area->name}}</td>
                        <td><a href="{{route('area.edit', $area->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('area.destroy',$area->id)}}" method="POST">
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

        {{ $areas->links() }}

    </div>

@endsection