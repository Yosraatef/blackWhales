@extends('dashboard.index')
@section('content')
    <h2> التحويلات</h2>
    <div class="col-sm-6">

        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th> اسم المستخدم </th>
                <th> سعر العمولة </th>
                <th>  صورة الإصال</th>
                <th>مشاهدة التفاصيل </th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($commissions) > 0)
                @foreach($commissions as $commission)
                <?php $userName = DB::table('users')->where('id',$commission->user_id)->value('name');?>
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$userName}}</td>
                        <td>{{$commission->amountMony}}</td>
                        <td><img style="hight:120px;width:120px;margin:5px;" src="{{ asset('public/pictures/commissions/' . $commission->imageRecepit) }}"></td>
                        
                        <td><a href="{{route('commissions.edit', $commission->id)}}">
                                     <button class="btn btn-outline-success" >
                                        مشاهدة 
                                    </button>
                                    </a>
                        </td>

                        <td>

                            <form action="{{route('commissions.destroy',$commission->id)}}" method="POST">
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