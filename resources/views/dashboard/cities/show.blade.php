@extends('dashboard.index')
@section('content')
    <h3>المدن </h3>
    <div class="col-md-12 col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>  الدولة</th>
                <th>المدينة</th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($cities) > 0)
                @foreach($cities as $city)
                   
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$city->country->name}}</td>
                        <td>{{$city->name}}</td>
                        <td><a href="{{route('city.edit', $city->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('city.destroy',$city->id)}}" method="POST">
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

        {{ $cities->links() }}

    </div>

@endsection