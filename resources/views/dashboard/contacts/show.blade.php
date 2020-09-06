@extends('dashboard.index')



@section('content')
    <h4> رسائل تواصل معانا الخاصة بالتطبيق</h4>

    
    <div class="col-sm-6">


        <table class="table">
            <thead>
            <tr>
                <th>الرقم</th>
                <th>الاسم </th>
                
                <th> رقم الهاتف  </th>
                <th> الرسالة </th>
                <th>الحدث</th>
            </tr>
            </thead>
           
            @if(count($contacts) > 0)
                @foreach($contacts as $contact)
                
                    <tbody>
                    <tr>
                        <td>{{$loop->index +1 }}</td>
                        <td>{{$contact->name}}</td>
                        
                        <td>{{$contact->phone}}</td>
                        <td>{{$contact->message}}</td>
                       
                         <td>

                            <form action="{{route('contact.destroy',$contact->id)}}" method="POST">
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

        {{ $contacts->links() }}

    </div>

@endsection