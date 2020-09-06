@extends('dashboard.index')
@section('content')

    <section class="content">
        <div class="card" style="width: 18rem; float: right;margin: 10px;" >
            
            <div class="card-body">

                <p class="card-text">
                    <strong>
                        عدد  المستخدمين  :: {{$users}} مستخدم 
                    </strong>
                   
                </p>
                <a href="{{route('users.create')}}"
                   class="btn btn-primary">إضافة  مستخدم  جديد </a>
            </div>
        </div>
        <div class="card" style="width: 18rem; float: right;margin: 10px;" >

            <div class="card-body">

                <p class="card-text">
                    <strong>
                        عدد  الأصناف الموجودة لدينا  :: {{$categories}} أصناف 
                    </strong>
                   
                </p>
                <a href="{{route('categories.create')}}"
                   class="btn btn-primary">إضافة صنف جديد </a>
            </div>
        </div>
       
          <div class="card" style="width: 18rem;float: right;margin: 10px;">

            <div class="card-body">

                <p class="card-text">
                    <strong>
                        عدد  الطلبات :: طلب
                    </strong>
                    
                </p>
                <a href="#"
                   class="btn btn-primary">رؤية تفاصيل  الطلبات</a>
            </div>
        </div>
        
    </section>


        <script>
        function printDiv()
        {

            var divToPrint=document.getElementById('DivIdToPrint');

            var newWin=window.open('','Print-Window');

            newWin.document.open();

            newWin.document.write('<html lang="ar" style="text-align: right"><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

            newWin.document.close();

            setTimeout(function(){newWin.close();},10);

        }
    </script>


@endsection
