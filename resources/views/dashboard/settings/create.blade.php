@extends('dashboard.index')


@section('content')
    
<div class=" col-sm-6">

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



    <form action="{{route('settings.store')}}" method="POST" >

        @csrf
        <div class="form-group">
            <label for="name">نص تحذري</label>
            <textarea name="WarningText"
                      id=""
                      cols="30"
                      rows="10"
                      class="form-control">
                @if(array_key_exists("WarningText",$settings_data)){{$settings_data["WarningText"]}}@endif
            </textarea>
        </div>
        
         <div class="form-group">
            <label for="name">الشروط والاحكام</label>
            <textarea name="conditions"
                      id=""
                      cols="30"
                      rows="15"
                      class="form-control">
                @if(array_key_exists("conditions",$settings_data)){{$settings_data["conditions"]}}@endif
            </textarea>
        </div>
        <div class="form-group">
            <label for="name">من  نحن</label>
            <textarea name="who"
                      id=""
                      cols="30"
                      rows="10"
                      class="form-control">
                @if(array_key_exists("who",$settings_data)){{$settings_data["who"]}}@endif
            </textarea>
        </div>
        
        <div class="form-group">
            <input type="submit"  value="Add" class="form-control">
        </div>


    </form>


</div>
@stop