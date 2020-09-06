@extends('dashboard.index')
@section('content')
    <h2> الحسابات</h2>
    <div class="col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th> اسم البنك </th>
                <th> رقم الحساب </th>
                <th> الابيان </th>
                <th> اسم المستفيد   </th>
                <th>  صورة المصرف</th>
                <th>تعديل</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($accounts) > 0)
                @foreach($accounts as $account)
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$account->nameAccount}}</td>
                        <td>{{$account->numberAccount}}</td>
                        <td>{{$account->appearance}}</td>
                        <td>{{$account->beneficiary}}</td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/accounts/' . $account->image) }}"></td>
                        
                        <td><a href="{{route('accounts.edit', $account->id)}}">
                                     <button class="btn btn-outline-warning" >
                                        تعديل 
                                    </button>
                                    </a>
                        </td>

                        <td>

                            <form action="{{route('accounts.destroy',$account->id)}}" method="POST">
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