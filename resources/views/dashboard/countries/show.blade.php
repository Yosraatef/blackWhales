@extends('dashboard.index')
@section('content')
    <h2> الأقسام الرئسية</h2>
    <div class="col-md-12 col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th> الاسم </th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($countries) > 0)
                @foreach($countries as $country)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$country->name}}</td>
                                           
                        <td><a href="{{route('country.edit', $country->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>

                        <td>

                            <form action="{{route('country.destroy',$country->id)}}" method="POST">
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

        {{ $countries->links() }}

    </div>

@endsection