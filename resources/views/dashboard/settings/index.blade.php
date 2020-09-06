
@extends('dashboard.index')



@section('content')
    <h2>الاعدادت </h2>

    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>اسم الشركة</th>
                <th>رقم الجوال </th>
                <th>البريد الالكتروني</th>
                <th>عين الشركة</th>
                <th>تاريخ الانشاء</th>
                <th>تاريخ التحديث</th>
                <th>Action</th>
            </tr>
            </thead>
            @if(count($settings) > 0)
                @foreach($settings as $setting)
                    <tbody>
                    <tr>
                        <td>{{ $setting->id }}</td>
                        
                        <td>
                            {{$setting->value}}
                        </td>
                        <td>{{ $setting->created_at->diffForHumans() }}</td>
                        <td>{{ $setting->updated_at->diffForHumans() }}</td>
                        <td><a href="{{route('settings.create',$setting->id)}}" class="btn btn-outline-success btn-sm">تحديث</a></td>
                    </tr>
                    </tbody>
                @endforeach
            @endif
        </table>




    </div>

@endsection