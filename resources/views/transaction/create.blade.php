@extends('layouts.adminlte4')
@section('content')
<!-- fill with your page bar like previous week HERE !-->
<!-- end page bar !-->
<!-- END PAGE HEADER-->
<form method="POST" action="{{route('transaction.store')}}">
    <div class="container">
        @csrf
        <div class="form-group">
            <label for="service">Service</label>
            <select class="form-select" id="service_id" name="service_id" aria-describedby="name" required="">
                <option value="" selected="" disabled="">Choose a service...</option>
                @foreach ($services as $service)
                <option value="{{$service->id}}">{{$service->service_name}}</option>
                @endforeach
            </select><br>
            <label for="user">User</label>
            <select class="form-select" id="user_id" name="user_id" aria-describedby="name" required="">
                <option value="" selected="" disabled="">Choose a user...</option>
                @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select><br>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection