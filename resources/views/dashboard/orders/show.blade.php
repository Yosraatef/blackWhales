@extends('dashboard.index')

@section('content')
    <h2> الطلبات</h2>

    
    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>اسم  صاحب الطلب</th>
                <th> اسم الخدمه الرئسيه  </th>
                <th> اسم الخدمة الفرعية  </th>
                <th>  العنوان  </th>
                <th>رقم التلفون </th>
                <th>حاله الطلب</th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($orders) > 0)
                @foreach($orders as $order)
                    <?php
                        $user = DB::table('users')->where('id',$order->user_id)->first();             
                        $service = DB::table('services')->where('id',$order->service_id)->first();             
                        $cat = DB::table('categories')->where('id',$service->category_id)->first();             
                        $subCat = DB::table('sub_categories')->where('id',$service->subCategory_id)->first();             
                        ?>
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$cat->name}}</td>
                        <td>{{$subCat->name}}</td>
                        <td>{{$service->address}} </td>
                        <td>{{$user->phone}}</td>
                        @if($order->status == 0)
                        <td>قيد  الانتظار </td>

                         <td>
                            <form action="{{route('status',$order->id)}}" method="POST">
                                @csrf

                                <button class="btn btn-outline-warning">انهاء</button>

                            </form> 
                        </td>
                        @else
                        <td> منتهية</td>
                         <td>
                             <form action="{{route('status',$order->id)}}" method="POST">
                                @csrf

                                <button class="btn btn-outline-danger" >
                                        قيد  النتظار  
                                    </button>

                            </form> 
                        </td>
                        @endif
                       
                        

                    </tr>
                    </tbody>
                @endforeach
            @endif
        </table>

        {{ $orders->links() }}

    </div>

@endsection