@extends('dashboard.index')
@section('content')
    <h2> المستخدمين</h2>
    <div class="col-md-12 col-sm-6">
        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th> الاسم </th>
                <th> رقم  التلفون </th>
                <th>البريد الالكتروني</th>
                <th> صورة الملف الشخصي </th>
              
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($users) > 0)
                @foreach($users as $user)
                  @if($user->type == 0)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->email}}</td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('pictures/users/' . $user->image) }}"></td>
                        
                        <td><a href="{{route('users.edit', $user->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>
                        <td>

                            <form action="{{route('users.destroy',$user->id)}}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button class="btn btn-outline-danger">احذف</button>

                            </form> 
                        </td>

                    </tr>
                    </tbody>
                    @endif
                @endforeach
            @endif
        </table>

        {{ $users->links() }}

    </div>

@endsection